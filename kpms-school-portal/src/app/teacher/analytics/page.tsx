"use client";

import { useState, useEffect, useCallback } from "react";
import { createClient } from "@/lib/supabase/client";
import { getInitials } from "@/lib/utils";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  PieChart,
  Pie,
  Cell,
  ResponsiveContainer,
} from "recharts";
import {
  Brain,
  TrendingUp,
  AlertTriangle,
  BookOpen,
  ArrowLeft,
  Loader2,
  BarChart3,
  Users,
} from "lucide-react";

// KPMS color palette for charts
const CHART_COLORS = [
  "#003087",
  "#FFD100",
  "#0A8F6C",
  "#E8443A",
  "#8B5CF6",
  "#F59E0B",
  "#3B82F6",
  "#EC4899",
  "#14B8A6",
  "#F97316",
];

interface StudentUsageRow {
  student_id: string;
  total_messages: number;
  student_name: string;
}

interface SubjectBreakdown {
  subject: string;
  count: number;
}

interface InactiveStudent {
  id: string;
  full_name: string;
  grade: string;
  section: string;
  last_active: string | null;
}

interface TopicEntry {
  topic: string;
  count: number;
}

interface StudentDetail {
  student_id: string;
  full_name: string;
  engagement_score: number | null;
  subjects: string[];
  topics_struggled: string[];
  total_messages: number;
  total_sessions: number;
}

export default function AIAnalyticsPage() {
  const supabase = createClient();
  const [loading, setLoading] = useState(true);
  const [topStudents, setTopStudents] = useState<StudentUsageRow[]>([]);
  const [subjectData, setSubjectData] = useState<SubjectBreakdown[]>([]);
  const [inactiveStudents, setInactiveStudents] = useState<InactiveStudent[]>(
    []
  );
  const [commonTopics, setCommonTopics] = useState<TopicEntry[]>([]);
  const [selectedStudentDetail, setSelectedStudentDetail] =
    useState<StudentDetail | null>(null);
  const [loadingDetail, setLoadingDetail] = useState(false);

  const fetchAnalytics = useCallback(async () => {
    setLoading(true);
    try {
      const weekAgo = new Date();
      weekAgo.setDate(weekAgo.getDate() - 7);
      const weekAgoStr = weekAgo.toISOString().split("T")[0];

      // 1. Top 10 most active students by messages this week
      const { data: usageData } = await supabase
        .from("ai_usage")
        .select("student_id, messages_sent")
        .gte("date", weekAgoStr);

      // Aggregate by student
      const studentMessages = new Map<string, number>();
      usageData?.forEach((row) => {
        const current = studentMessages.get(row.student_id) ?? 0;
        studentMessages.set(row.student_id, current + row.messages_sent);
      });

      // Get student names for the IDs
      const studentIds = Array.from(studentMessages.keys());
      let studentNameMap = new Map<string, string>();

      if (studentIds.length > 0) {
        const { data: studentProfiles } = await supabase
          .from("students")
          .select("id, full_name")
          .in("id", studentIds);

        studentProfiles?.forEach((s) =>
          studentNameMap.set(s.id, s.full_name)
        );
      }

      const topStudentsList = Array.from(studentMessages.entries())
        .map(([id, total]) => ({
          student_id: id,
          total_messages: total,
          student_name: studentNameMap.get(id) ?? "Unknown",
        }))
        .sort((a, b) => b.total_messages - a.total_messages)
        .slice(0, 10);

      setTopStudents(topStudentsList);

      // 2. Subject breakdown from ai_engagement
      const { data: engagementData } = await supabase
        .from("ai_engagement")
        .select("subject")
        .not("subject", "is", null);

      const subjectCounts = new Map<string, number>();
      engagementData?.forEach((row) => {
        if (row.subject) {
          const current = subjectCounts.get(row.subject) ?? 0;
          subjectCounts.set(row.subject, current + 1);
        }
      });

      const subjectList = Array.from(subjectCounts.entries())
        .map(([subject, count]) => ({ subject, count }))
        .sort((a, b) => b.count - a.count);

      setSubjectData(subjectList);

      // 3. Students who haven't used tutor recently
      const { data: allStudents } = await supabase
        .from("students")
        .select("id, full_name, grade, section")
        .eq("is_active", true)
        .order("full_name");

      const activeStudentIds = new Set(studentIds);
      const inactive: InactiveStudent[] = [];

      if (allStudents) {
        for (const s of allStudents) {
          if (!activeStudentIds.has(s.id)) {
            // Check last activity
            const { data: lastUsage } = await supabase
              .from("ai_usage")
              .select("date")
              .eq("student_id", s.id)
              .order("date", { ascending: false })
              .limit(1);

            inactive.push({
              id: s.id,
              full_name: s.full_name,
              grade: s.grade,
              section: s.section,
              last_active: lastUsage?.[0]?.date ?? null,
            });
          }
        }
      }

      setInactiveStudents(inactive.slice(0, 20));

      // 4. Common topics from ai_engagement
      const { data: topicData } = await supabase
        .from("ai_engagement")
        .select("topics_covered")
        .not("topics_covered", "is", null);

      const topicCounts = new Map<string, number>();
      topicData?.forEach((row) => {
        if (row.topics_covered && Array.isArray(row.topics_covered)) {
          row.topics_covered.forEach((t: string) => {
            const current = topicCounts.get(t) ?? 0;
            topicCounts.set(t, current + 1);
          });
        }
      });

      const topicList = Array.from(topicCounts.entries())
        .map(([topic, count]) => ({ topic, count }))
        .sort((a, b) => b.count - a.count)
        .slice(0, 15);

      setCommonTopics(topicList);
    } catch (err) {
      console.error("Failed to fetch analytics:", err);
    } finally {
      setLoading(false);
    }
  }, [supabase]);

  useEffect(() => {
    fetchAnalytics();
  }, [fetchAnalytics]);

  async function viewStudentDetail(studentId: string, studentName: string) {
    setLoadingDetail(true);

    try {
      // Get engagement data
      const { data: engagements } = await supabase
        .from("ai_engagement")
        .select("*")
        .eq("student_id", studentId)
        .order("created_at", { ascending: false });

      // Get usage data
      const { data: usage } = await supabase
        .from("ai_usage")
        .select("*")
        .eq("student_id", studentId);

      const totalMessages =
        usage?.reduce((sum, u) => sum + u.messages_sent, 0) ?? 0;

      // Aggregate subjects
      const subjects = new Set<string>();
      const struggleTopics = new Set<string>();
      let totalScore = 0;
      let scoreCount = 0;

      engagements?.forEach((e) => {
        if (e.subject) subjects.add(e.subject);
        if (e.engagement_score !== null) {
          totalScore += e.engagement_score;
          scoreCount++;
        }
        if (e.struggle_signals && Array.isArray(e.struggle_signals)) {
          e.struggle_signals.forEach((s: string) => struggleTopics.add(s));
        }
      });

      setSelectedStudentDetail({
        student_id: studentId,
        full_name: studentName,
        engagement_score:
          scoreCount > 0 ? Math.round(totalScore / scoreCount) : null,
        subjects: Array.from(subjects),
        topics_struggled: Array.from(struggleTopics),
        total_messages: totalMessages,
        total_sessions: engagements?.length ?? 0,
      });
    } catch (err) {
      console.error("Failed to fetch student detail:", err);
    } finally {
      setLoadingDetail(false);
    }
  }

  // ── STUDENT DETAIL VIEW ──
  if (selectedStudentDetail) {
    const detail = selectedStudentDetail;
    const scoreColor =
      detail.engagement_score !== null
        ? detail.engagement_score >= 70
          ? "#0A8F6C"
          : detail.engagement_score >= 40
          ? "#F59E0B"
          : "#E8443A"
        : "#5a6577";

    return (
      <div className="space-y-6 max-w-4xl">
        <button
          onClick={() => setSelectedStudentDetail(null)}
          className="flex items-center gap-2 text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors cursor-pointer"
        >
          <ArrowLeft className="w-4 h-4" />
          Back to Analytics
        </button>

        <div className="flex items-center gap-4">
          <div className="w-14 h-14 rounded-full bg-[#003087] flex items-center justify-center text-white text-lg font-bold">
            {getInitials(detail.full_name)}
          </div>
          <div>
            <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
              {detail.full_name}
            </h1>
            <p className="text-sm text-[#5a6577]">AI Tutor Engagement Detail</p>
          </div>
        </div>

        {/* Stats Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
            <p className="text-sm text-[#5a6577]">Engagement Score</p>
            <p
              className="text-3xl font-bold mt-1"
              style={{ color: scoreColor }}
            >
              {detail.engagement_score !== null
                ? `${detail.engagement_score}%`
                : "N/A"}
            </p>
          </div>
          <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
            <p className="text-sm text-[#5a6577]">Total Messages</p>
            <p className="text-3xl font-bold text-[#003087] mt-1">
              {detail.total_messages}
            </p>
          </div>
          <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
            <p className="text-sm text-[#5a6577]">Sessions</p>
            <p className="text-3xl font-bold text-[#FFD100] mt-1">
              {detail.total_sessions}
            </p>
          </div>
        </div>

        {/* Subjects */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <h3 className="font-heading font-semibold text-[#1a1a2e] mb-3">
            Subjects Studied
          </h3>
          {detail.subjects.length > 0 ? (
            <div className="flex flex-wrap gap-2">
              {detail.subjects.map((s) => (
                <span
                  key={s}
                  className="inline-flex items-center px-3 py-1 rounded-lg bg-[#003087]/10 text-[#003087] text-sm font-medium"
                >
                  <BookOpen className="w-3.5 h-3.5 mr-1.5" />
                  {s}
                </span>
              ))}
            </div>
          ) : (
            <p className="text-sm text-[#5a6577]">No subjects recorded</p>
          )}
        </div>

        {/* Struggle Topics */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <h3 className="font-heading font-semibold text-[#1a1a2e] mb-3">
            Areas of Struggle
          </h3>
          {detail.topics_struggled.length > 0 ? (
            <div className="flex flex-wrap gap-2">
              {detail.topics_struggled.map((t) => (
                <span
                  key={t}
                  className="inline-flex items-center px-3 py-1 rounded-lg bg-[#E8443A]/10 text-[#E8443A] text-sm font-medium"
                >
                  <AlertTriangle className="w-3.5 h-3.5 mr-1.5" />
                  {t}
                </span>
              ))}
            </div>
          ) : (
            <p className="text-sm text-[#5a6577]">
              No struggle signals detected
            </p>
          )}
        </div>
      </div>
    );
  }

  // ── LOADING ──
  if (loading) {
    return (
      <div className="space-y-6 max-w-6xl">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            AI Tutor Analytics
          </h1>
          <p className="text-sm text-[#5a6577] mt-1">
            Monitor student engagement with the AI Tutor
          </p>
        </div>
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <Loader2 className="w-8 h-8 text-[#003087] animate-spin mb-3" />
          <p className="text-sm text-[#5a6577]">Loading analytics...</p>
        </div>
      </div>
    );
  }

  // ── MAIN ANALYTICS VIEW ──
  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div>
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
          AI Tutor Analytics
        </h1>
        <p className="text-sm text-[#5a6577] mt-1">
          Monitor student engagement with the AI Tutor
        </p>
      </div>

      {/* Charts Row */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Bar Chart: Messages per Student (Top 10) */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <div className="flex items-center gap-2 mb-4">
            <BarChart3 className="w-5 h-5 text-[#003087]" />
            <h2 className="font-heading font-semibold text-[#1a1a2e]">
              Top Active Students (This Week)
            </h2>
          </div>

          {topStudents.length > 0 ? (
            <ResponsiveContainer width="100%" height={300}>
              <BarChart
                data={topStudents}
                margin={{ top: 5, right: 20, left: 0, bottom: 60 }}
              >
                <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" />
                <XAxis
                  dataKey="student_name"
                  tick={{ fontSize: 11, fill: "#5a6577" }}
                  angle={-45}
                  textAnchor="end"
                  height={80}
                />
                <YAxis
                  tick={{ fontSize: 11, fill: "#5a6577" }}
                  allowDecimals={false}
                />
                <Tooltip
                  contentStyle={{
                    borderRadius: "12px",
                    border: "1px solid #e2e8f0",
                    fontSize: "13px",
                  }}
                  labelStyle={{ fontWeight: 600, color: "#1a1a2e" }}
                />
                <Bar
                  dataKey="total_messages"
                  name="Messages"
                  fill="#003087"
                  radius={[6, 6, 0, 0]}
                />
              </BarChart>
            </ResponsiveContainer>
          ) : (
            <div className="h-[300px] flex flex-col items-center justify-center">
              <BarChart3 className="w-12 h-12 text-[#5a6577]/30 mb-3" />
              <p className="text-sm text-[#5a6577]">
                No usage data this week
              </p>
            </div>
          )}
        </div>

        {/* Pie Chart: Subject Breakdown */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <div className="flex items-center gap-2 mb-4">
            <BookOpen className="w-5 h-5 text-[#FFD100]" />
            <h2 className="font-heading font-semibold text-[#1a1a2e]">
              Subject Breakdown
            </h2>
          </div>

          {subjectData.length > 0 ? (
            <div className="flex flex-col items-center">
              <ResponsiveContainer width="100%" height={250}>
                <PieChart>
                  <Pie
                    data={subjectData}
                    dataKey="count"
                    nameKey="subject"
                    cx="50%"
                    cy="50%"
                    outerRadius={90}
                    innerRadius={40}
                    paddingAngle={2}
                    label={(props: any) =>
                      `${props.name || ''} ${((props.percent || 0) * 100).toFixed(0)}%`
                    }
                    labelLine={{ stroke: "#5a6577" }}
                  >
                    {subjectData.map((_, i) => (
                      <Cell
                        key={i}
                        fill={CHART_COLORS[i % CHART_COLORS.length]}
                      />
                    ))}
                  </Pie>
                  <Tooltip
                    contentStyle={{
                      borderRadius: "12px",
                      border: "1px solid #e2e8f0",
                      fontSize: "13px",
                    }}
                  />
                </PieChart>
              </ResponsiveContainer>
              {/* Legend */}
              <div className="flex flex-wrap gap-3 mt-2 justify-center">
                {subjectData.map((s, i) => (
                  <span
                    key={s.subject}
                    className="flex items-center gap-1.5 text-xs text-[#5a6577]"
                  >
                    <span
                      className="w-2.5 h-2.5 rounded-full"
                      style={{
                        backgroundColor:
                          CHART_COLORS[i % CHART_COLORS.length],
                      }}
                    />
                    {s.subject}
                  </span>
                ))}
              </div>
            </div>
          ) : (
            <div className="h-[300px] flex flex-col items-center justify-center">
              <BookOpen className="w-12 h-12 text-[#5a6577]/30 mb-3" />
              <p className="text-sm text-[#5a6577]">No subject data yet</p>
            </div>
          )}
        </div>
      </div>

      {/* Bottom Row */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Inactive Students */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <div className="flex items-center gap-2 mb-4">
            <Users className="w-5 h-5 text-[#E8443A]" />
            <h2 className="font-heading font-semibold text-[#1a1a2e]">
              Students Not Using Tutor
            </h2>
          </div>

          {inactiveStudents.length > 0 ? (
            <div className="space-y-2 max-h-[400px] overflow-y-auto">
              {inactiveStudents.map((s) => (
                <div
                  key={s.id}
                  onClick={() => viewStudentDetail(s.id, s.full_name)}
                  className="flex items-center gap-3 p-3 rounded-xl hover:bg-[#F5F7FB] transition-colors cursor-pointer"
                >
                  <div className="w-9 h-9 rounded-full bg-[#E8443A]/10 flex items-center justify-center text-[#E8443A] text-xs font-semibold shrink-0">
                    {getInitials(s.full_name)}
                  </div>
                  <div className="flex-1 min-w-0">
                    <p className="text-sm font-medium text-[#1a1a2e] truncate">
                      {s.full_name}
                    </p>
                    <p className="text-xs text-[#5a6577]">
                      {s.grade}-{s.section}
                      {s.last_active
                        ? ` | Last active: ${new Date(s.last_active).toLocaleDateString()}`
                        : " | Never used"}
                    </p>
                  </div>
                  <AlertTriangle className="w-4 h-4 text-[#E8443A]/60 shrink-0" />
                </div>
              ))}
            </div>
          ) : (
            <div className="py-8 text-center">
              <TrendingUp className="w-12 h-12 text-[#0A8F6C]/30 mx-auto mb-3" />
              <p className="text-sm text-[#5a6577]">
                All students are using the AI Tutor!
              </p>
            </div>
          )}
        </div>

        {/* Common Topics */}
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <div className="flex items-center gap-2 mb-4">
            <TrendingUp className="w-5 h-5 text-[#0A8F6C]" />
            <h2 className="font-heading font-semibold text-[#1a1a2e]">
              Most Common Topics
            </h2>
          </div>

          {commonTopics.length > 0 ? (
            <div className="space-y-2 max-h-[400px] overflow-y-auto">
              {commonTopics.map((topic, i) => {
                const maxCount = commonTopics[0]?.count ?? 1;
                const widthPct = Math.max(
                  (topic.count / maxCount) * 100,
                  10
                );

                return (
                  <div key={topic.topic} className="space-y-1">
                    <div className="flex items-center justify-between">
                      <p className="text-sm text-[#1a1a2e] truncate">
                        {i + 1}. {topic.topic}
                      </p>
                      <span className="text-xs font-medium text-[#5a6577] shrink-0 ml-2">
                        {topic.count}
                      </span>
                    </div>
                    <div className="h-2 bg-[#F5F7FB] rounded-full overflow-hidden">
                      <div
                        className="h-full rounded-full transition-all duration-500"
                        style={{
                          width: `${widthPct}%`,
                          backgroundColor:
                            CHART_COLORS[i % CHART_COLORS.length],
                        }}
                      />
                    </div>
                  </div>
                );
              })}
            </div>
          ) : (
            <div className="py-8 text-center">
              <Brain className="w-12 h-12 text-[#5a6577]/30 mx-auto mb-3" />
              <p className="text-sm text-[#5a6577]">
                No topic data available yet
              </p>
            </div>
          )}
        </div>
      </div>

      {/* Clickable Student List for Details */}
      {topStudents.length > 0 && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
          <div className="flex items-center gap-2 mb-4">
            <Brain className="w-5 h-5 text-[#8B5CF6]" />
            <h2 className="font-heading font-semibold text-[#1a1a2e]">
              Student Engagement Details
            </h2>
          </div>
          <p className="text-sm text-[#5a6577] mb-3">
            Click a student to view their detailed AI Tutor engagement
          </p>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
            {topStudents.map((s) => (
              <button
                key={s.student_id}
                onClick={() =>
                  viewStudentDetail(s.student_id, s.student_name)
                }
                disabled={loadingDetail}
                className="flex items-center gap-3 p-3 rounded-xl hover:bg-[#F5F7FB] transition-colors text-left cursor-pointer disabled:opacity-50"
              >
                <div className="w-9 h-9 rounded-full bg-[#003087] flex items-center justify-center text-white text-xs font-semibold shrink-0">
                  {getInitials(s.student_name)}
                </div>
                <div className="min-w-0">
                  <p className="text-sm font-medium text-[#1a1a2e] truncate">
                    {s.student_name}
                  </p>
                  <p className="text-xs text-[#5a6577]">
                    {s.total_messages} messages this week
                  </p>
                </div>
              </button>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
