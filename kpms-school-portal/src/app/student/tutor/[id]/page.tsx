"use client";

import { useState, useEffect, useRef } from "react";
import { useParams, useRouter } from "next/navigation";
import { createClient } from "@/lib/supabase/client";
import { AI_BUDGET } from "@/lib/ai-config";
import {
  ArrowLeft,
  Send,
  Volume2,
  Loader2,
  Shield,
  MessageSquare,
} from "lucide-react";
import Link from "next/link";
import type { AIMessage, AIConversation } from "@/types";
import VoiceButton from "@/components/tutor/VoiceButton";

export default function ChatPage() {
  const params = useParams();
  const router = useRouter();
  const conversationId = params.id as string;
  const supabase = createClient();

  const [conversation, setConversation] = useState<AIConversation | null>(null);
  const [messages, setMessages] = useState<AIMessage[]>([]);
  const [input, setInput] = useState("");
  const [sending, setSending] = useState(false);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [remainingMessages, setRemainingMessages] = useState(
    AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT
  );
  const [studentId, setStudentId] = useState<string | null>(null);
  const [playingAudio, setPlayingAudio] = useState<string | null>(null);

  const scrollRef = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    loadConversation();
  }, [conversationId]);

  useEffect(() => {
    scrollToBottom();
  }, [messages, sending]);

  function scrollToBottom() {
    if (scrollRef.current) {
      scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
    }
  }

  async function loadConversation() {
    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();
      if (!user) {
        router.push("/login");
        return;
      }

      // Get student id
      const { data: studentAccount } = await supabase
        .from("student_accounts")
        .select("student_id")
        .eq("user_id", user.id)
        .single();

      if (!studentAccount) {
        router.push("/login");
        return;
      }

      setStudentId(studentAccount.student_id);

      // Load conversation
      const { data: conv } = await supabase
        .from("ai_conversations")
        .select("*")
        .eq("id", conversationId)
        .eq("student_id", studentAccount.student_id)
        .single();

      if (!conv) {
        router.push("/student/tutor");
        return;
      }

      setConversation(conv);

      // Load messages
      const { data: msgs } = await supabase
        .from("ai_messages")
        .select("*")
        .eq("conversation_id", conversationId)
        .order("created_at", { ascending: true });

      if (msgs) {
        setMessages(msgs);
      }

      // Check daily usage
      const today = new Date().toISOString().split("T")[0];
      const { data: usage } = await supabase
        .from("ai_usage")
        .select("messages_sent")
        .eq("student_id", studentAccount.student_id)
        .eq("date", today)
        .single();

      if (usage) {
        setRemainingMessages(
          Math.max(
            0,
            AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT - usage.messages_sent
          )
        );
      }
    } catch {
      setError("Failed to load conversation");
    } finally {
      setLoading(false);
    }
  }

  async function sendMessage(text: string) {
    if (!text.trim() || sending || !studentId || !conversation) return;
    if (remainingMessages <= 0) return;

    const trimmedText = text.trim();
    setInput("");
    setSending(true);
    setError(null);

    // Optimistically add user message
    const tempUserMsg: AIMessage = {
      id: `temp-${Date.now()}`,
      conversation_id: conversationId,
      role: "user",
      content: trimmedText,
      tokens_used_input: 0,
      tokens_used_output: 0,
      voice_used: false,
      created_at: new Date().toISOString(),
    };
    setMessages((prev) => [...prev, tempUserMsg]);

    try {
      const res = await fetch("/api/ai/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          conversationId,
          message: trimmedText,
          studentId,
          subject: conversation.subject || "General Knowledge",
          language: conversation.language || "en",
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        throw new Error(data.error || "Failed to send message");
      }

      // Add assistant response
      const assistantMsg: AIMessage = {
        id: `resp-${Date.now()}`,
        conversation_id: conversationId,
        role: "assistant",
        content: data.reply,
        tokens_used_input: 0,
        tokens_used_output: 0,
        voice_used: false,
        created_at: new Date().toISOString(),
      };
      setMessages((prev) => [...prev, assistantMsg]);
      setRemainingMessages(data.remainingMessages ?? remainingMessages - 1);
    } catch (err: unknown) {
      const errorMessage =
        err instanceof Error ? err.message : "Failed to send message";
      setError(errorMessage);
      // Remove optimistic message on error
      setMessages((prev) => prev.filter((m) => m.id !== tempUserMsg.id));
    } finally {
      setSending(false);
      inputRef.current?.focus();
    }
  }

  async function playAudio(messageId: string, text: string) {
    if (playingAudio === messageId) return;
    setPlayingAudio(messageId);

    try {
      const res = await fetch("/api/ai/voice-response", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          text,
          language: conversation?.language || "en",
        }),
      });

      if (!res.ok) throw new Error("Failed to generate audio");

      const blob = await res.blob();
      const url = URL.createObjectURL(blob);
      const audio = new Audio(url);
      audio.onended = () => {
        setPlayingAudio(null);
        URL.revokeObjectURL(url);
      };
      audio.onerror = () => {
        setPlayingAudio(null);
        URL.revokeObjectURL(url);
      };
      await audio.play();
    } catch {
      setPlayingAudio(null);
    }
  }

  function handleVoiceTranscript(text: string) {
    setInput(text);
    inputRef.current?.focus();
  }

  if (loading) {
    return (
      <div className="flex items-center justify-center h-[70vh]">
        <Loader2 className="w-8 h-8 animate-spin text-[#003087]" />
      </div>
    );
  }

  const limitReached = remainingMessages <= 0;

  return (
    <div className="flex flex-col h-[calc(100vh-5rem)] max-w-3xl mx-auto">
      {/* Safety Banner */}
      <div className="bg-[#003087]/5 border border-[#003087]/10 rounded-t-xl px-4 py-2 flex items-center gap-2">
        <Shield className="w-4 h-4 text-[#003087] shrink-0" />
        <p className="text-xs text-[#003087]">
          KPMS Learning Assistant — I&apos;m here to help with your studies!
        </p>
      </div>

      {/* Top Bar */}
      <div className="bg-white border-x border-b border-[#e2e8f0] px-4 py-3 flex items-center justify-between">
        <div className="flex items-center gap-3">
          <Link
            href="/student/tutor"
            className="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-[#F5F7FB] transition-colors"
          >
            <ArrowLeft className="w-4 h-4 text-[#5a6577]" />
          </Link>
          <div>
            <h1 className="text-sm font-semibold text-[#1a1a2e]">
              {conversation?.subject || "Chat"}
            </h1>
            <p className="text-xs text-[#5a6577]">
              {conversation?.title || "KPMS Ustaad"}
            </p>
          </div>
        </div>
        <div className="flex items-center gap-1.5 text-xs text-[#5a6577]">
          <MessageSquare className="w-3.5 h-3.5" />
          {remainingMessages} left
        </div>
      </div>

      {/* Messages */}
      <div
        ref={scrollRef}
        className="flex-1 overflow-y-auto bg-[#F5F7FB] border-x border-[#e2e8f0] px-4 py-4 space-y-4"
      >
        {messages
          .filter((m) => m.role !== "system")
          .map((msg) => (
            <div
              key={msg.id}
              className={`flex ${
                msg.role === "user" ? "justify-end" : "justify-start"
              }`}
            >
              {msg.role === "assistant" && (
                <div className="w-8 h-8 rounded-full bg-[#FFD100] flex items-center justify-center text-[#1a1a2e] text-xs font-bold shrink-0 mr-2 mt-1">
                  U
                </div>
              )}
              <div className="max-w-[80%]">
                <div
                  className={`rounded-2xl px-4 py-3 text-sm leading-relaxed ${
                    msg.role === "user"
                      ? "bg-[#003087] text-white rounded-br-md"
                      : "bg-white text-[#1a1a2e] rounded-bl-md border-l-[3px] border-[#FFD100] ring-1 ring-[#e2e8f0]"
                  }`}
                >
                  <span className="whitespace-pre-wrap">{msg.content}</span>
                </div>
                {msg.role === "assistant" && (
                  <button
                    onClick={() => playAudio(msg.id, msg.content)}
                    disabled={playingAudio !== null}
                    className="mt-1 ml-1 inline-flex items-center gap-1 text-xs text-[#5a6577] hover:text-[#003087] transition-colors disabled:opacity-50"
                  >
                    {playingAudio === msg.id ? (
                      <Loader2 className="w-3 h-3 animate-spin" />
                    ) : (
                      <Volume2 className="w-3 h-3" />
                    )}
                    Read Aloud
                  </button>
                )}
              </div>
            </div>
          ))}

        {/* Typing Indicator */}
        {sending && (
          <div className="flex justify-start">
            <div className="w-8 h-8 rounded-full bg-[#FFD100] flex items-center justify-center text-[#1a1a2e] text-xs font-bold shrink-0 mr-2 mt-1">
              U
            </div>
            <div className="bg-white rounded-2xl rounded-bl-md px-4 py-3 ring-1 ring-[#e2e8f0] border-l-[3px] border-[#FFD100]">
              <div className="flex items-center gap-1">
                <div className="w-2 h-2 bg-[#003087] rounded-full animate-bounce" />
                <div
                  className="w-2 h-2 bg-[#003087] rounded-full animate-bounce"
                  style={{ animationDelay: "0.1s" }}
                />
                <div
                  className="w-2 h-2 bg-[#003087] rounded-full animate-bounce"
                  style={{ animationDelay: "0.2s" }}
                />
              </div>
            </div>
          </div>
        )}
      </div>

      {/* Limit Reached Message */}
      {limitReached && (
        <div className="bg-[#FFD100]/10 border-x border-[#e2e8f0] px-4 py-3">
          <p className="text-sm text-[#1a1a2e] text-center font-medium">
            You&apos;ve used all your messages for today!
          </p>
          <p className="text-xs text-[#5a6577] text-center mt-0.5">
            Great job learning! Come back tomorrow for more.
          </p>
        </div>
      )}

      {/* Error Message */}
      {error && (
        <div className="bg-[#E8443A]/10 border-x border-[#e2e8f0] px-4 py-2">
          <p className="text-sm text-[#E8443A] text-center">{error}</p>
        </div>
      )}

      {/* Input Area */}
      <div className="bg-white border border-[#e2e8f0] rounded-b-xl px-4 py-3">
        <form
          onSubmit={(e) => {
            e.preventDefault();
            sendMessage(input);
          }}
          className="flex items-center gap-2"
        >
          <VoiceButton
            language={conversation?.language === "ur" ? "ur-PK" : "en-US"}
            onTranscript={handleVoiceTranscript}
          />
          <input
            ref={inputRef}
            type="text"
            placeholder={
              limitReached
                ? "Daily limit reached"
                : "Ask Ustaad a question..."
            }
            value={input}
            onChange={(e) => setInput(e.target.value)}
            disabled={sending || limitReached}
            className="flex-1 h-10 px-4 rounded-xl bg-[#F5F7FB] text-sm text-[#1a1a2e] placeholder:text-[#5a6577] outline-none focus:ring-2 focus:ring-[#003087]/20 disabled:opacity-50 disabled:cursor-not-allowed"
          />
          <button
            type="submit"
            disabled={!input.trim() || sending || limitReached}
            className="w-10 h-10 rounded-xl bg-[#003087] text-white flex items-center justify-center hover:bg-[#003087]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shrink-0"
          >
            {sending ? (
              <Loader2 className="w-4 h-4 animate-spin" />
            ) : (
              <Send className="w-4 h-4" />
            )}
          </button>
        </form>
        <p className="text-[10px] text-[#5a6577] mt-2 text-center">
          KPMS Ustaad is an AI assistant. Responses may not always be accurate.
        </p>
      </div>
    </div>
  );
}
