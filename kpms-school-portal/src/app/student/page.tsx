import { redirect } from "next/navigation";
import { createServerSupabase } from "@/lib/supabase/server";
import Link from "next/link";
import {
  Sparkles,
  BookOpen,
  TrendingUp,
  CalendarCheck,
  MessageSquare,
  Megaphone,
  ChevronRight,
} from "lucide-react";
import { formatDate, getGradeColor } from "@/lib/utils";

export default async function StudentDashboard() {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) {
    redirect("/login");
  }

  // Get profile
  const { data: profile } = await supabase
    .from("profiles")
    .select("*")
    .eq("id", user.id)
    .single();

  if (!profile) {
    redirect("/login");
  }

  // Get student record
  const { data: studentAccount } = await supabase
    .from("student_accounts")
    .select("student_id")
    .eq("user_id", user.id)
    .single();

  if (!studentAccount) {
    redirect("/login");
  }

  const studentId = studentAccount.student_id;

  const { data: student } = await supabase
    .from("students")
    .select("*")
    .eq("id", studentId)
    .single();

  // Get attendance stats
  const { data: attendance } = await supabase
    .from("attendance")
    .select("status")
    .eq("student_id", studentId);

  const totalDays = attendance?.length || 0;
  const presentDays =
    attendance?.filter(
      (a) => a.status === "present" || a.status === "late"
    ).length || 0;
  const attendancePercent =
    totalDays > 0 ? Math.round((presentDays / totalDays) * 100) : 0;

  // Get grades summary
  const { data: grades } = await supabase
    .from("grades")
    .select("*")
    .eq("student_id", studentId)
    .order("created_at", { ascending: false });

  const avgGrade =
    grades && grades.length > 0
      ? Math.round(
          grades.reduce((sum, g) => sum + (g.grade_percent || 0), 0) /
            grades.length
        )
      : 0;

  // Get recent AI conversations
  const { data: conversations } = await supabase
    .from("ai_conversations")
    .select("*")
    .eq("student_id", studentId)
    .order("updated_at", { ascending: false })
    .limit(3);

  // Get today's announcements
  const today = new Date().toISOString().split("T")[0];
  const { data: announcements } = await supabase
    .from("announcements")
    .select("*")
    .or(`expires_at.is.null,expires_at.gte.${today}`)
    .order("created_at", { ascending: false })
    .limit(3);

  const firstName = profile.full_name?.split(" ")[0] || "Student";

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Welcome Banner */}
      <div className="bg-gradient-to-r from-[#003087] to-[#1D5FAF] rounded-2xl p-6 lg:p-8 text-white relative overflow-hidden">
        <div className="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4" />
        <div className="relative">
          <h1 className="font-heading text-2xl lg:text-3xl font-bold">
            Assalam-o-Alaikum, {firstName}!
          </h1>
          <p className="text-blue-100 mt-2 text-sm lg:text-base">
            Ready to learn today?
          </p>
          {student && (
            <p className="text-blue-200 text-xs mt-1">
              Grade {student.grade} - Section {student.section}
            </p>
          )}
        </div>
      </div>

      {/* Quick Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div className="bg-white rounded-xl p-4 ring-1 ring-[#e2e8f0]">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-lg bg-[#003087]/10 flex items-center justify-center">
              <CalendarCheck className="w-5 h-5 text-[#003087]" />
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">Attendance</p>
              <p className="text-xl font-bold text-[#1a1a2e]">
                {attendancePercent}%
              </p>
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl p-4 ring-1 ring-[#e2e8f0]">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-lg bg-[#0A8F6C]/10 flex items-center justify-center">
              <TrendingUp className="w-5 h-5 text-[#0A8F6C]" />
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">Avg Grade</p>
              <p
                className="text-xl font-bold"
                style={{ color: getGradeColor(avgGrade) }}
              >
                {avgGrade > 0 ? `${avgGrade}%` : "--"}
              </p>
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl p-4 ring-1 ring-[#e2e8f0]">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-lg bg-[#8B5CF6]/10 flex items-center justify-center">
              <BookOpen className="w-5 h-5 text-[#8B5CF6]" />
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">Subjects</p>
              <p className="text-xl font-bold text-[#1a1a2e]">
                {grades
                  ? new Set(grades.map((g) => g.subject)).size
                  : 0}
              </p>
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl p-4 ring-1 ring-[#e2e8f0]">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-lg bg-[#FFD100]/10 flex items-center justify-center">
              <MessageSquare className="w-5 h-5 text-[#F59E0B]" />
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">AI Chats</p>
              <p className="text-xl font-bold text-[#1a1a2e]">
                {conversations?.length || 0}
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Start Learning CTA */}
      <Link
        href="/student/tutor"
        className="block bg-gradient-to-r from-[#FFD100] to-[#F59E0B] rounded-2xl p-6 hover:shadow-lg transition-shadow group"
      >
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-4">
            <div className="w-14 h-14 rounded-xl bg-white/30 flex items-center justify-center">
              <Sparkles className="w-7 h-7 text-[#1a1a2e]" />
            </div>
            <div>
              <h2 className="font-heading text-xl font-bold text-[#1a1a2e]">
                Start Learning
              </h2>
              <p className="text-[#1a1a2e]/70 text-sm">
                Chat with KPMS Ustaad - your personal AI tutor
              </p>
            </div>
          </div>
          <ChevronRight className="w-6 h-6 text-[#1a1a2e] group-hover:translate-x-1 transition-transform" />
        </div>
      </Link>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Recent AI Conversations */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] overflow-hidden">
          <div className="px-5 py-4 border-b border-[#e2e8f0] flex items-center justify-between">
            <h2 className="font-heading text-base font-semibold text-[#1a1a2e]">
              Recent Conversations
            </h2>
            <Link
              href="/student/tutor"
              className="text-xs text-[#003087] hover:underline"
            >
              View All
            </Link>
          </div>
          <div className="divide-y divide-[#e2e8f0]">
            {conversations && conversations.length > 0 ? (
              conversations.map((conv) => (
                <Link
                  key={conv.id}
                  href={`/student/tutor/${conv.id}`}
                  className="flex items-center gap-3 p-4 hover:bg-[#F5F7FB] transition-colors"
                >
                  <div className="w-9 h-9 rounded-lg bg-[#003087]/10 flex items-center justify-center shrink-0">
                    <Sparkles className="w-4 h-4 text-[#003087]" />
                  </div>
                  <div className="min-w-0 flex-1">
                    <p className="text-sm font-medium text-[#1a1a2e] truncate">
                      {conv.title || conv.subject || "Conversation"}
                    </p>
                    <p className="text-xs text-[#5a6577]">
                      {conv.subject} - {conv.message_count} messages
                    </p>
                  </div>
                  <span className="text-xs text-[#5a6577] shrink-0">
                    {formatDate(conv.updated_at)}
                  </span>
                </Link>
              ))
            ) : (
              <div className="p-8 text-center">
                <Sparkles className="w-8 h-8 text-[#e2e8f0] mx-auto mb-2" />
                <p className="text-sm text-[#5a6577]">
                  No conversations yet. Start learning!
                </p>
              </div>
            )}
          </div>
        </div>

        {/* Today's Announcements */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] overflow-hidden">
          <div className="px-5 py-4 border-b border-[#e2e8f0]">
            <h2 className="font-heading text-base font-semibold text-[#1a1a2e]">
              Announcements
            </h2>
          </div>
          <div className="divide-y divide-[#e2e8f0]">
            {announcements && announcements.length > 0 ? (
              announcements.map((ann) => (
                <div key={ann.id} className="p-4">
                  <div className="flex items-start gap-3">
                    <div
                      className={`w-2 h-2 rounded-full mt-1.5 shrink-0 ${
                        ann.priority === "urgent"
                          ? "bg-[#E8443A]"
                          : ann.priority === "important"
                          ? "bg-[#F59E0B]"
                          : "bg-[#003087]"
                      }`}
                    />
                    <div className="min-w-0">
                      <p className="text-sm font-medium text-[#1a1a2e]">
                        {ann.title}
                      </p>
                      <p className="text-xs text-[#5a6577] mt-1 line-clamp-2">
                        {ann.message}
                      </p>
                      <p className="text-xs text-[#5a6577] mt-1">
                        {formatDate(ann.created_at)}
                      </p>
                    </div>
                  </div>
                </div>
              ))
            ) : (
              <div className="p-8 text-center">
                <Megaphone className="w-8 h-8 text-[#e2e8f0] mx-auto mb-2" />
                <p className="text-sm text-[#5a6577]">
                  No announcements right now
                </p>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
