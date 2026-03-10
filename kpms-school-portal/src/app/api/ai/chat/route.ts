import { NextRequest, NextResponse } from "next/server";
import OpenAI from "openai";
import { createServiceRoleClient } from "@/lib/supabase/server";
import {
  getSystemPrompt,
  AI_BUDGET,
  estimateCostCents,
} from "@/lib/ai-config";
import type { ChatRequest, ChatResponse, TutorMeta } from "@/types";

const openai = new OpenAI();

export async function POST(req: NextRequest) {
  try {
    const body: ChatRequest = await req.json();
    const { conversationId, message, studentId, subject, language } = body;

    if (!message || !studentId || !subject) {
      return NextResponse.json(
        { error: "Missing required fields: message, studentId, subject" },
        { status: 400 }
      );
    }

    const supabase = createServiceRoleClient();

    // Check monthly budget
    const currentMonth = new Date();
    currentMonth.setDate(1);
    const monthStr = currentMonth.toISOString().split("T")[0];

    const { data: budget } = await supabase
      .from("ai_budget")
      .select("*")
      .eq("month", monthStr)
      .single();

    if (budget && budget.spent_cents >= budget.budget_limit_cents) {
      return NextResponse.json(
        {
          error:
            "Monthly AI budget has been reached. Please contact your teacher.",
        },
        { status: 429 }
      );
    }

    // Check daily usage for this student
    const today = new Date().toISOString().split("T")[0];
    const { data: usage } = await supabase
      .from("ai_usage")
      .select("*")
      .eq("student_id", studentId)
      .eq("date", today)
      .single();

    const messagesSentToday = usage?.messages_sent || 0;

    if (messagesSentToday >= AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT) {
      return NextResponse.json(
        {
          error:
            "You have used all your messages for today. Come back tomorrow!",
          remainingMessages: 0,
        },
        { status: 429 }
      );
    }

    // Get student details for system prompt
    const { data: student } = await supabase
      .from("students")
      .select("full_name, grade")
      .eq("id", studentId)
      .single();

    const studentName = student?.full_name || "Student";
    const studentGrade = student?.grade || "5";

    let activeConversationId = conversationId;

    // If no conversationId, create new conversation
    if (!activeConversationId) {
      const { data: newConv, error: convError } = await supabase
        .from("ai_conversations")
        .insert({
          student_id: studentId,
          subject,
          title: message.slice(0, 100),
          language: language || "en",
          message_count: 0,
          is_active: true,
        })
        .select("id")
        .single();

      if (convError || !newConv) {
        console.error("Failed to create conversation:", convError);
        return NextResponse.json(
          { error: "Failed to create conversation" },
          { status: 500 }
        );
      }

      activeConversationId = newConv.id;
    }

    // Fetch last 10 messages for context
    const { data: historyMessages } = await supabase
      .from("ai_messages")
      .select("role, content")
      .eq("conversation_id", activeConversationId)
      .order("created_at", { ascending: false })
      .limit(10);

    // Build messages array
    const systemPrompt = getSystemPrompt(
      studentName,
      studentGrade,
      subject,
      language || "en"
    );

    const contextMessages: Array<{
      role: "system" | "user" | "assistant";
      content: string;
    }> = [{ role: "system", content: systemPrompt }];

    // Add history in chronological order
    if (historyMessages && historyMessages.length > 0) {
      const chronological = [...historyMessages].reverse();
      for (const msg of chronological) {
        if (msg.role === "user" || msg.role === "assistant") {
          contextMessages.push({
            role: msg.role,
            content: msg.content,
          });
        }
      }
    }

    // Add the new user message
    contextMessages.push({ role: "user", content: message });

    // Call OpenAI
    const completion = await openai.chat.completions.create({
      model: AI_BUDGET.MODEL,
      messages: contextMessages,
      max_tokens: AI_BUDGET.MAX_OUTPUT_TOKENS,
      temperature: 0.7,
    });

    const fullReply =
      completion.choices[0]?.message?.content ||
      "I'm sorry, I couldn't generate a response. Please try again.";

    // Parse TUTOR_META from response
    let metadata: TutorMeta | null = null;
    let cleanReply = fullReply;

    const metaMatch = fullReply.match(
      /<!--TUTOR_META:([\s\S]*?)-->/
    );
    if (metaMatch) {
      try {
        metadata = JSON.parse(metaMatch[1]);
      } catch {
        // Metadata parsing failed, continue without it
      }
      cleanReply = fullReply.replace(/<!--TUTOR_META:[\s\S]*?-->/, "").trim();
    }

    // Calculate tokens and cost
    const inputTokens = completion.usage?.prompt_tokens || 0;
    const outputTokens = completion.usage?.completion_tokens || 0;
    const costCents = estimateCostCents(inputTokens, outputTokens);

    // Insert user message into ai_messages
    await supabase.from("ai_messages").insert({
      conversation_id: activeConversationId,
      role: "user",
      content: message,
      tokens_used_input: 0,
      tokens_used_output: 0,
      voice_used: false,
    });

    // Insert assistant message into ai_messages
    await supabase.from("ai_messages").insert({
      conversation_id: activeConversationId,
      role: "assistant",
      content: cleanReply,
      tokens_used_input: inputTokens,
      tokens_used_output: outputTokens,
      voice_used: false,
    });

    // Upsert ai_usage
    if (usage) {
      await supabase
        .from("ai_usage")
        .update({
          messages_sent: usage.messages_sent + 1,
          input_tokens: (usage.input_tokens || 0) + inputTokens,
          output_tokens: (usage.output_tokens || 0) + outputTokens,
          estimated_cost_cents:
            (usage.estimated_cost_cents || 0) + costCents,
        })
        .eq("id", usage.id);
    } else {
      await supabase.from("ai_usage").insert({
        student_id: studentId,
        date: today,
        messages_sent: 1,
        input_tokens: inputTokens,
        output_tokens: outputTokens,
        voice_minutes: 0,
        estimated_cost_cents: costCents,
      });
    }

    // Update ai_budget spent_cents
    if (budget) {
      await supabase
        .from("ai_budget")
        .update({
          spent_cents: budget.spent_cents + costCents,
          is_budget_exceeded:
            budget.spent_cents + costCents >= budget.budget_limit_cents,
        })
        .eq("id", budget.id);
    } else {
      // Create budget entry for current month
      await supabase.from("ai_budget").insert({
        month: monthStr,
        budget_limit_cents: AI_BUDGET.MONTHLY_LIMIT_CENTS,
        spent_cents: costCents,
        is_budget_exceeded: costCents >= AI_BUDGET.MONTHLY_LIMIT_CENTS,
      });
    }

    // Update conversation message_count and title
    const { data: convData } = await supabase
      .from("ai_conversations")
      .select("message_count, title")
      .eq("id", activeConversationId)
      .single();

    const newCount = (convData?.message_count || 0) + 2; // user + assistant
    const updateData: Record<string, unknown> = {
      message_count: newCount,
      updated_at: new Date().toISOString(),
    };

    // Set title from first message if not set
    if (!convData?.title || convData.title === message.slice(0, 100)) {
      // Keep existing title or set from first real question
      if (!convData?.title) {
        updateData.title = message.slice(0, 100);
      }
    }

    await supabase
      .from("ai_conversations")
      .update(updateData)
      .eq("id", activeConversationId);

    const newRemaining =
      AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT - (messagesSentToday + 1);

    const response: ChatResponse = {
      reply: cleanReply,
      metadata,
      remainingMessages: Math.max(0, newRemaining),
      conversationId: activeConversationId!,
    };

    return NextResponse.json(response);
  } catch (error: unknown) {
    // Handle OpenAI API key errors gracefully
    if (
      error instanceof Error &&
      ("status" in error || "code" in error)
    ) {
      const apiError = error as { status?: number; code?: string };
      if (
        apiError.status === 401 ||
        apiError.code === "invalid_api_key" ||
        !process.env.OPENAI_API_KEY
      ) {
        return NextResponse.json(
          {
            reply:
              "The AI Tutor is currently in demo mode. To enable full AI responses, the school administrator needs to configure the OpenAI API key.",
            metadata: null,
            remainingMessages: 29,
            conversationId: "demo",
          },
          { status: 200 }
        );
      }
    }

    console.error("AI Chat API error:", error);
    return NextResponse.json(
      { error: "Something went wrong. Please try again." },
      { status: 500 }
    );
  }
}
