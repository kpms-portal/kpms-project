import { createServerSupabase } from "@/lib/supabase/server";
import { redirect } from "next/navigation";
import { formatDate } from "@/lib/utils";
import {
  Users,
  CalendarCheck,
  MessageSquare,
  Brain,
  ArrowRight,
  Mail,
} from "lucide-react";
import Link from "next/link";

export default async function TeacherDashboard() {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) redirect("/auth/login");

  // Fetch profile
  const { data: profile } = await supabase
    .from("profiles")
    .select("full_name")
    .eq("id", user.id)
    .single();

  // Total students
  const { count: totalStudents } = await supabase
    .from("students")
    .select("*", { count: "exact", head: true })
    .eq("is_active", true);

  // Today's attendance count
  const today = new Date().toISOString().split("T")[0];
  const { count: todayAttendance } = await supabase
    .from("attendance_records")
    .select("*", { count: "exact", head: true })
    .eq("date", today)
    .eq("status", "present");

  // Pending (unread) messages for this teacher
  const { count: pendingMessages } = await supabase
    .from("messages")
    .select("*", { count: "exact", head: true })
    .eq("receiver_id", user.id)
    .eq("is_read", false);

  // Active AI Tutor sessions (sessions from this week)
  const weekAgo = new Date();
  weekAgo.setDate(weekAgo.getDate() - 7);
  const { count: activeAISessions } = await supabase
    .from("ai_conversations")
    .select("*", { count: "exact", head: true })
    .eq("is_active", true)
    .gte("updated_at", weekAgo.toISOString());

  // Recent parent messages (last 3)
  const { data: recentMessages } = await supabase
    .from("messages")
    .select(
      `
      id,
      subject,
      message,
      is_read,
      created_at,
      sender:profiles!messages_sender_id_fkey(full_name, role)
    `
    )
    .eq("receiver_id", user.id)
    .order("created_at", { ascending: false })
    .limit(3);

  // AI Tutor class engagement this week
  const { count: weeklyAIUsers } = await supabase
    .from("ai_usage")
    .select("student_id", { count: "exact", head: true })
    .gte("date", weekAgo.toISOString().split("T")[0]);

  const todayFormatted = new Date().toLocaleDateString("en-US", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  const summaryCards = [
    {
      icon: Users,
      label: "Total Students",
      value: String(totalStudents ?? 0),
      color: "#003087",
    },
    {
      icon: CalendarCheck,
      label: "Present Today",
      value: String(todayAttendance ?? 0),
      color: "#0A8F6C",
    },
    {
      icon: MessageSquare,
      label: "Pending Messages",
      value: String(pendingMessages ?? 0),
      color: "#F59E0B",
    },
    {
      icon: Brain,
      label: "Active AI Sessions",
      value: String(activeAISessions ?? 0),
      color: "#8B5CF6",
    },
  ];

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Welcome Banner */}
      <div className="bg-gradient-to-r from-[#003087] to-[#1D5FAF] rounded-2xl p-6 text-white">
        <div className="flex items-center justify-between flex-wrap gap-4">
          <div>
            <h1 className="font-heading text-2xl font-bold">
              Welcome, {profile?.full_name ?? "Teacher"}!
            </h1>
            <p className="text-blue-100 mt-1 text-sm">{todayFormatted}</p>
          </div>
          <div className="bg-white/20 rounded-xl px-4 py-2 text-sm font-medium">
            Teacher Portal
          </div>
        </div>
      </div>

      {/* Summary Cards */}
      <section>
        <h2 className="font-heading text-lg font-semibold text-[#1a1a2e] mb-3">
          Overview
        </h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {summaryCards.map((card) => {
            const Icon = card.icon;
            return (
              <div
                key={card.label}
                className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5 flex items-center gap-4 hover:shadow-md transition-shadow"
              >
                <div
                  className="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                  style={{ backgroundColor: `${card.color}15` }}
                >
                  <span style={{ color: card.color }}><Icon className="w-6 h-6" /></span>
                </div>
                <div>
                  <p className="text-2xl font-bold text-[#1a1a2e]">
                    {card.value}
                  </p>
                  <p className="text-sm text-[#5a6577]">{card.label}</p>
                </div>
              </div>
            );
          })}
        </div>
      </section>

      {/* Recent Messages + Quick Actions */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Recent Parent Messages */}
        <div className="lg:col-span-2">
          <div className="flex items-center justify-between mb-3">
            <h2 className="font-heading text-lg font-semibold text-[#1a1a2e]">
              Recent Messages
            </h2>
            <Link
              href="/teacher/messages"
              className="text-sm text-[#003087] hover:underline flex items-center gap-1"
            >
              View all <ArrowRight className="w-4 h-4" />
            </Link>
          </div>

          {recentMessages && recentMessages.length > 0 ? (
            <div className="space-y-2">
              {recentMessages.map((msg: Record<string, unknown>) => {
                const sender = msg.sender as Record<string, unknown> | null;
                return (
                  <div
                    key={msg.id as string}
                    className={`bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 hover:shadow-md transition-shadow ${
                      !(msg.is_read as boolean)
                        ? "border-l-4 border-l-[#003087]"
                        : ""
                    }`}
                  >
                    <div className="flex items-start gap-3">
                      <div className="w-10 h-10 rounded-full bg-[#003087] flex items-center justify-center shrink-0">
                        <Mail className="w-5 h-5 text-white" />
                      </div>
                      <div className="flex-1 min-w-0">
                        <div className="flex items-center justify-between gap-2">
                          <p
                            className={`text-sm truncate ${
                              !(msg.is_read as boolean)
                                ? "font-bold text-[#1a1a2e]"
                                : "font-medium text-[#1a1a2e]"
                            }`}
                          >
                            {(sender?.full_name as string) ?? "Unknown"}
                          </p>
                          <span className="text-xs text-[#5a6577] shrink-0">
                            {formatDate(msg.created_at as string)}
                          </span>
                        </div>
                        <p className="text-sm text-[#5a6577] truncate">
                          {(msg.subject as string) ?? "No subject"}
                        </p>
                        <p className="text-xs text-[#5a6577] truncate mt-0.5">
                          {(msg.message as string)?.split("\n")[0]}
                        </p>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          ) : (
            <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-8 text-center">
              <MessageSquare className="w-12 h-12 text-[#5a6577]/40 mx-auto mb-3" />
              <p className="text-sm text-[#5a6577]">No messages yet</p>
            </div>
          )}
        </div>

        {/* Quick Actions + AI Summary */}
        <div className="space-y-6">
          {/* Quick Actions */}
          <div>
            <h2 className="font-heading text-lg font-semibold text-[#1a1a2e] mb-3">
              Quick Actions
            </h2>
            <div className="space-y-2">
              <Link
                href="/teacher/attendance"
                className="flex items-center gap-3 bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 hover:shadow-md transition-shadow group"
              >
                <div className="w-10 h-10 rounded-xl bg-[#0A8F6C]/10 flex items-center justify-center shrink-0">
                  <CalendarCheck className="w-5 h-5 text-[#0A8F6C]" />
                </div>
                <div className="flex-1">
                  <p className="text-sm font-semibold text-[#1a1a2e]">
                    Mark Attendance
                  </p>
                  <p className="text-xs text-[#5a6577]">
                    Record today&apos;s attendance
                  </p>
                </div>
                <ArrowRight className="w-4 h-4 text-[#5a6577] group-hover:text-[#003087] transition-colors" />
              </Link>

              <Link
                href="/teacher/grades"
                className="flex items-center gap-3 bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 hover:shadow-md transition-shadow group"
              >
                <div className="w-10 h-10 rounded-xl bg-[#FFD100]/10 flex items-center justify-center shrink-0">
                  <svg
                    className="w-5 h-5 text-[#FFD100]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    strokeWidth={2}
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                    />
                  </svg>
                </div>
                <div className="flex-1">
                  <p className="text-sm font-semibold text-[#1a1a2e]">
                    Enter Grades
                  </p>
                  <p className="text-xs text-[#5a6577]">
                    Record student grades
                  </p>
                </div>
                <ArrowRight className="w-4 h-4 text-[#5a6577] group-hover:text-[#003087] transition-colors" />
              </Link>
            </div>
          </div>

          {/* AI Tutor Engagement Summary */}
          <div>
            <h2 className="font-heading text-lg font-semibold text-[#1a1a2e] mb-3">
              AI Tutor This Week
            </h2>
            <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
              <div className="flex items-center gap-3 mb-3">
                <div className="w-10 h-10 rounded-xl bg-[#8B5CF6]/10 flex items-center justify-center">
                  <Brain className="w-5 h-5 text-[#8B5CF6]" />
                </div>
                <div>
                  <p className="text-2xl font-bold text-[#1a1a2e]">
                    {weeklyAIUsers ?? 0}
                  </p>
                  <p className="text-xs text-[#5a6577]">
                    students used AI Tutor
                  </p>
                </div>
              </div>
              <Link
                href="/teacher/analytics"
                className="text-sm text-[#003087] hover:underline flex items-center gap-1"
              >
                View analytics <ArrowRight className="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
