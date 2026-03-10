import { NextRequest, NextResponse } from "next/server";
import { createServiceRoleClient } from "@/lib/supabase/server";
import { AI_BUDGET } from "@/lib/ai-config";

export async function GET(req: NextRequest) {
  try {
    const { searchParams } = new URL(req.url);
    const studentId = searchParams.get("studentId");

    if (!studentId) {
      return NextResponse.json(
        { error: "studentId query parameter is required" },
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

    const monthlySpent = budget?.spent_cents || 0;
    const monthlyLimit =
      budget?.budget_limit_cents || AI_BUDGET.MONTHLY_LIMIT_CENTS;

    // Check student daily usage
    const today = new Date().toISOString().split("T")[0];
    const { data: usage } = await supabase
      .from("ai_usage")
      .select("messages_sent")
      .eq("student_id", studentId)
      .eq("date", today)
      .single();

    const messagesSentToday = usage?.messages_sent || 0;
    const remainingMessages = Math.max(
      0,
      AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT - messagesSentToday
    );
    const withinBudget =
      monthlySpent < monthlyLimit && remainingMessages > 0;

    return NextResponse.json({
      withinBudget,
      remainingMessages,
      monthlySpent,
      monthlyLimit,
    });
  } catch (error) {
    console.error("Budget check error:", error);
    return NextResponse.json(
      { error: "Failed to check budget" },
      { status: 500 }
    );
  }
}
