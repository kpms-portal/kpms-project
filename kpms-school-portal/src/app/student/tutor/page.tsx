"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { createClient } from "@/lib/supabase/client";
import { SUBJECTS, AI_BUDGET } from "@/lib/ai-config";
import Link from "next/link";
import {
  Calculator,
  FlaskConical,
  BookOpen,
  Languages,
  Star,
  Globe,
  Monitor,
  Lightbulb,
  Sparkles,
  Clock,
  MessageSquare,
  Loader2,
} from "lucide-react";
import { formatDate } from "@/lib/utils";
import type { AIConversation } from "@/types";

const iconMap: Record<string, React.ComponentType<{ className?: string }>> = {
  Calculator,
  FlaskConical,
  BookOpen,
  Languages,
  Star,
  Globe,
  Monitor,
  Lightbulb,
};

export default function TutorPage() {
  const router = useRouter();
  const supabase = createClient();
  const [conversations, setConversations] = useState<AIConversation[]>([]);
  const [loading, setLoading] = useState(true);
  const [creating, setCreating] = useState<string | null>(null);
  const [language, setLanguage] = useState<"en" | "ur" | "mixed">("en");
  const [usageToday, setUsageToday] = useState(0);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    loadData();
  }, []);

  async function loadData() {
    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();
      if (!user) return;

      // Get student account
      const { data: studentAccount } = await supabase
        .from("student_accounts")
        .select("student_id")
        .eq("user_id", user.id)
        .single();

      if (!studentAccount) return;

      // Load recent conversations
      const { data: convos } = await supabase
        .from("ai_conversations")
        .select("*")
        .eq("student_id", studentAccount.student_id)
        .eq("is_active", true)
        .order("updated_at", { ascending: false })
        .limit(5);

      if (convos) setConversations(convos);

      // Load today's usage
      const today = new Date().toISOString().split("T")[0];
      const { data: usage } = await supabase
        .from("ai_usage")
        .select("messages_sent")
        .eq("student_id", studentAccount.student_id)
        .eq("date", today)
        .single();

      if (usage) setUsageToday(usage.messages_sent);

      // Load language preference
      const { data: profile } = await supabase
        .from("profiles")
        .select("language_preference")
        .eq("id", user.id)
        .single();

      if (profile?.language_preference) {
        setLanguage(profile.language_preference as "en" | "ur" | "mixed");
      }
    } catch {
      setError("Failed to load data");
    } finally {
      setLoading(false);
    }
  }

  async function startConversation(subjectId: string, subjectName: string) {
    if (creating) return;
    setCreating(subjectId);
    setError(null);

    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();
      if (!user) throw new Error("Not authenticated");

      const { data: studentAccount } = await supabase
        .from("student_accounts")
        .select("student_id")
        .eq("user_id", user.id)
        .single();

      if (!studentAccount) throw new Error("Student account not found");

      // Send a first message to create the conversation via the API
      const res = await fetch("/api/ai/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          studentId: studentAccount.student_id,
          subject: subjectName,
          language,
          message: `Hi! I want to learn about ${subjectName}. Can you help me?`,
        }),
      });

      if (!res.ok) {
        const data = await res.json();
        throw new Error(data.error || "Failed to start conversation");
      }

      const data = await res.json();
      router.push(`/student/tutor/${data.conversationId}`);
    } catch (err: unknown) {
      const errorMessage =
        err instanceof Error ? err.message : "Failed to start conversation";
      setError(errorMessage);
      setCreating(null);
    }
  }

  const dailyLimit = AI_BUDGET.DAILY_MESSAGE_LIMIT_PER_STUDENT;
  const remainingMessages = Math.max(0, dailyLimit - usageToday);
  const usagePercent = Math.min(100, (usageToday / dailyLimit) * 100);

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <Loader2 className="w-8 h-8 animate-spin text-[#003087]" />
      </div>
    );
  }

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-[#003087]/10 flex items-center justify-center">
            <Sparkles className="w-5 h-5 text-[#003087]" />
          </div>
          <div>
            <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
              AI Tutor
            </h1>
            <p className="text-sm text-[#5a6577]">
              Choose a subject to start learning
            </p>
          </div>
        </div>

        {/* Language Toggle */}
        <div className="flex items-center gap-1 bg-white rounded-xl p-1 ring-1 ring-[#e2e8f0]">
          {(["en", "ur", "mixed"] as const).map((lang) => (
            <button
              key={lang}
              onClick={() => setLanguage(lang)}
              className={`px-3 py-1.5 rounded-lg text-xs font-medium transition-all ${
                language === lang
                  ? "bg-[#003087] text-white"
                  : "text-[#5a6577] hover:text-[#1a1a2e]"
              }`}
            >
              {lang === "en" ? "English" : lang === "ur" ? "Urdu" : "Mixed"}
            </button>
          ))}
        </div>
      </div>

      {/* Daily Usage Meter */}
      <div className="bg-white rounded-xl p-4 ring-1 ring-[#e2e8f0]">
        <div className="flex items-center justify-between mb-2">
          <div className="flex items-center gap-2">
            <MessageSquare className="w-4 h-4 text-[#5a6577]" />
            <span className="text-sm text-[#5a6577]">
              Daily Messages
            </span>
          </div>
          <span className="text-sm font-medium text-[#1a1a2e]">
            {remainingMessages} remaining
          </span>
        </div>
        <div className="w-full h-2 bg-[#e2e8f0] rounded-full overflow-hidden">
          <div
            className="h-full rounded-full transition-all duration-500"
            style={{
              width: `${usagePercent}%`,
              backgroundColor:
                usagePercent >= 90
                  ? "#E8443A"
                  : usagePercent >= 70
                  ? "#F59E0B"
                  : "#0A8F6C",
            }}
          />
        </div>
        <p className="text-xs text-[#5a6577] mt-1">
          {usageToday} of {dailyLimit} messages used today
        </p>
      </div>

      {error && (
        <div className="bg-[#E8443A]/10 text-[#E8443A] text-sm rounded-xl px-4 py-3">
          {error}
        </div>
      )}

      {/* Subject Picker Grid */}
      <div>
        <h2 className="font-heading text-base font-semibold text-[#1a1a2e] mb-3">
          Pick a Subject
        </h2>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          {SUBJECTS.map((subject) => {
            const Icon = iconMap[subject.icon] || Lightbulb;
            const isCreating = creating === subject.id;
            return (
              <button
                key={subject.id}
                onClick={() => startConversation(subject.id, subject.name)}
                disabled={creating !== null || remainingMessages === 0}
                className="flex flex-col items-center gap-3 p-6 rounded-xl bg-white ring-1 ring-[#e2e8f0] hover:shadow-lg hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-none disabled:hover:translate-y-0 group"
              >
                <div
                  className="w-14 h-14 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110"
                  style={{ backgroundColor: `${subject.color}15` }}
                >
                  <span style={{ color: subject.color }}>
                    {isCreating ? (
                      <Loader2 className="w-7 h-7 animate-spin" />
                    ) : (
                      <Icon className="w-7 h-7" />
                    )}
                  </span>
                </div>
                <span className="text-sm font-medium text-[#1a1a2e] text-center">
                  {subject.name}
                </span>
              </button>
            );
          })}
        </div>
      </div>

      {/* Continue Learning */}
      {conversations.length > 0 && (
        <div>
          <h2 className="font-heading text-base font-semibold text-[#1a1a2e] mb-3">
            Continue Learning
          </h2>
          <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] overflow-hidden divide-y divide-[#e2e8f0]">
            {conversations.map((conv) => (
              <Link
                key={conv.id}
                href={`/student/tutor/${conv.id}`}
                className="flex items-center gap-3 p-4 hover:bg-[#F5F7FB] transition-colors"
              >
                <div className="w-10 h-10 rounded-lg bg-[#003087]/10 flex items-center justify-center shrink-0">
                  <Sparkles className="w-5 h-5 text-[#003087]" />
                </div>
                <div className="min-w-0 flex-1">
                  <p className="text-sm font-medium text-[#1a1a2e] truncate">
                    {conv.title || conv.subject || "Conversation"}
                  </p>
                  <div className="flex items-center gap-2 mt-0.5">
                    <span className="text-xs text-[#5a6577]">
                      {conv.subject}
                    </span>
                    <span className="text-xs text-[#e2e8f0]">|</span>
                    <span className="text-xs text-[#5a6577]">
                      {conv.message_count} messages
                    </span>
                  </div>
                </div>
                <div className="flex items-center gap-1.5 text-xs text-[#5a6577] shrink-0">
                  <Clock className="w-3 h-3" />
                  {formatDate(conv.updated_at)}
                </div>
              </Link>
            ))}
          </div>
        </div>
      )}

      {remainingMessages === 0 && (
        <div className="bg-[#FFD100]/10 rounded-xl p-6 text-center">
          <p className="text-sm font-medium text-[#1a1a2e]">
            You&apos;ve used all your messages for today!
          </p>
          <p className="text-xs text-[#5a6577] mt-1">
            Come back tomorrow for more learning. Your limit resets at midnight.
          </p>
        </div>
      )}
    </div>
  );
}
