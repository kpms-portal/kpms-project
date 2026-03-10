import { NextRequest, NextResponse } from "next/server";
import { createServerSupabase } from "@/lib/supabase/server";

export const revalidate = 300; // Cache for 5 minutes

interface EngagementMetrics {
  totalSessions: number;
  totalMessages: number;
  subjectsStudied: string[];
  students: StudentEngagement[];
}

interface StudentEngagement {
  studentId: string;
  studentName: string;
  sessions: number;
  messages: number;
  questionsAsked: number;
  comprehensionScore: number;
  consistencyScore: number;
  engagementScore: number;
  subjects: string[];
}

export async function GET(request: NextRequest) {
  try {
    const supabase = await createServerSupabase();

    // Verify authentication
    const {
      data: { user },
    } = await supabase.auth.getUser();

    if (!user) {
      return NextResponse.json(
        { error: "Not authenticated" },
        { status: 401 }
      );
    }

    const { searchParams } = new URL(request.url);
    const studentId = searchParams.get("studentId");
    const grade = searchParams.get("grade");
    const period = searchParams.get("period") || "month";

    // Calculate date range
    const now = new Date();
    let startDate: string;
    if (period === "week") {
      const weekAgo = new Date(now);
      weekAgo.setDate(weekAgo.getDate() - 7);
      startDate = weekAgo.toISOString().split("T")[0];
    } else {
      const monthAgo = new Date(now);
      monthAgo.setMonth(monthAgo.getMonth() - 1);
      startDate = monthAgo.toISOString().split("T")[0];
    }

    // Build queries based on filters
    let usageQuery = supabase
      .from("ai_usage")
      .select("student_id, messages_sent, date")
      .gte("date", startDate);

    let engagementQuery = supabase
      .from("ai_engagement")
      .select(
        "student_id, conversation_id, subject, messages_in_session, questions_asked, engagement_score, comprehension_signals, session_start"
      )
      .gte("session_start", `${startDate}T00:00:00`);

    let conversationsQuery = supabase
      .from("ai_conversations")
      .select("id, student_id, subject, message_count")
      .gte("created_at", `${startDate}T00:00:00`);

    // Apply student filter
    if (studentId) {
      usageQuery = usageQuery.eq("student_id", studentId);
      engagementQuery = engagementQuery.eq("student_id", studentId);
      conversationsQuery = conversationsQuery.eq("student_id", studentId);
    }

    // Apply grade filter - need to get student IDs for that grade first
    let gradeStudentIds: string[] | null = null;
    if (grade) {
      const { data: gradeStudents } = await supabase
        .from("students")
        .select("id")
        .eq("grade", grade)
        .eq("is_active", true);

      if (gradeStudents && gradeStudents.length > 0) {
        gradeStudentIds = gradeStudents.map((s) => s.id);
        usageQuery = usageQuery.in("student_id", gradeStudentIds);
        engagementQuery = engagementQuery.in("student_id", gradeStudentIds);
        conversationsQuery = conversationsQuery.in("student_id", gradeStudentIds);
      } else {
        // No students in this grade, return empty
        return NextResponse.json({
          totalSessions: 0,
          totalMessages: 0,
          subjectsStudied: [],
          students: [],
        });
      }
    }

    // Execute all queries in parallel
    const [
      { data: usageData },
      { data: engagementData },
      { data: conversationsData },
    ] = await Promise.all([usageQuery, engagementQuery, conversationsQuery]);

    const usage = usageData || [];
    const engagement = engagementData || [];
    const conversations = conversationsData || [];

    // Get all unique student IDs across data
    const allStudentIds = new Set<string>();
    usage.forEach((u) => allStudentIds.add(u.student_id));
    engagement.forEach((e) => allStudentIds.add(e.student_id));
    conversations.forEach((c) => allStudentIds.add(c.student_id));

    // Fetch student names
    const studentIds = Array.from(allStudentIds);
    const nameMap = new Map<string, string>();
    if (studentIds.length > 0) {
      const { data: studentsData } = await supabase
        .from("students")
        .select("id, full_name")
        .in("id", studentIds);
      (studentsData || []).forEach((s: { id: string; full_name: string }) => {
        nameMap.set(s.id, s.full_name);
      });
    }

    // Aggregate totals
    const totalMessages = usage.reduce((sum, u) => sum + u.messages_sent, 0);
    const totalSessions = engagement.length;

    // Unique subjects from conversations
    const subjectsSet = new Set<string>();
    conversations.forEach((c) => {
      if (c.subject) subjectsSet.add(c.subject);
    });
    engagement.forEach((e) => {
      if (e.subject) subjectsSet.add(e.subject);
    });
    const subjectsStudied = Array.from(subjectsSet);

    // Per-student engagement calculation
    const studentDataMap = new Map<
      string,
      {
        sessions: number;
        messages: number;
        questionsAsked: number;
        engagementScores: number[];
        comprehensionCount: number;
        comprehensionTotal: number;
        activeDays: Set<string>;
        subjects: Set<string>;
      }
    >();

    // Process engagement data
    engagement.forEach((e) => {
      if (!studentDataMap.has(e.student_id)) {
        studentDataMap.set(e.student_id, {
          sessions: 0,
          messages: 0,
          questionsAsked: 0,
          engagementScores: [],
          comprehensionCount: 0,
          comprehensionTotal: 0,
          activeDays: new Set(),
          subjects: new Set(),
        });
      }
      const data = studentDataMap.get(e.student_id)!;
      data.sessions += 1;
      data.messages += e.messages_in_session;
      data.questionsAsked += e.questions_asked || 0;
      if (e.engagement_score !== null) {
        data.engagementScores.push(e.engagement_score);
      }
      if (e.comprehension_signals && Array.isArray(e.comprehension_signals)) {
        data.comprehensionTotal += e.comprehension_signals.length;
        data.comprehensionCount += 1;
      }
      if (e.session_start) {
        data.activeDays.add(e.session_start.split("T")[0]);
      }
      if (e.subject) {
        data.subjects.add(e.subject);
      }
    });

    // Add usage data for students without engagement records
    usage.forEach((u) => {
      if (!studentDataMap.has(u.student_id)) {
        studentDataMap.set(u.student_id, {
          sessions: 0,
          messages: 0,
          questionsAsked: 0,
          engagementScores: [],
          comprehensionCount: 0,
          comprehensionTotal: 0,
          activeDays: new Set(),
          subjects: new Set(),
        });
      }
      const data = studentDataMap.get(u.student_id)!;
      data.activeDays.add(u.date);
    });

    // Add conversation subjects
    conversations.forEach((c) => {
      if (studentDataMap.has(c.student_id) && c.subject) {
        studentDataMap.get(c.student_id)!.subjects.add(c.subject);
      }
    });

    // Calculate engagement scores
    // Formula: sessions*0.2 + messages*0.15 + questions*0.25 + comprehension*0.25 + consistency*0.15
    const totalDays = period === "week" ? 7 : 30;

    const students: StudentEngagement[] = Array.from(studentDataMap.entries()).map(
      ([sid, data]) => {
        // Normalize factors (0-100 scale)
        const sessionScore = Math.min(data.sessions / (totalDays * 0.5), 1) * 100;
        const messageScore = Math.min(data.messages / (totalDays * 10), 1) * 100;
        const questionScore =
          data.questionsAsked > 0
            ? Math.min(data.questionsAsked / (data.sessions * 3 || 1), 1) * 100
            : 0;
        const comprehensionScore =
          data.comprehensionCount > 0
            ? (data.comprehensionTotal / data.comprehensionCount / 3) * 100
            : data.engagementScores.length > 0
              ? data.engagementScores.reduce((a, b) => a + b, 0) /
                data.engagementScores.length
              : 0;
        const consistencyScore =
          (data.activeDays.size / totalDays) * 100;

        const engagementScore = Math.round(
          sessionScore * 0.2 +
            messageScore * 0.15 +
            questionScore * 0.25 +
            comprehensionScore * 0.25 +
            consistencyScore * 0.15
        );

        return {
          studentId: sid,
          studentName: nameMap.get(sid) || "Unknown",
          sessions: data.sessions,
          messages: data.messages,
          questionsAsked: data.questionsAsked,
          comprehensionScore: Math.round(comprehensionScore),
          consistencyScore: Math.round(consistencyScore),
          engagementScore: Math.min(engagementScore, 100),
          subjects: Array.from(data.subjects),
        };
      }
    );

    // Sort by engagement score descending
    students.sort((a, b) => b.engagementScore - a.engagementScore);

    const result: EngagementMetrics = {
      totalSessions,
      totalMessages,
      subjectsStudied,
      students,
    };

    return NextResponse.json(result);
  } catch (err) {
    console.error("Engagement metrics error:", err);
    return NextResponse.json(
      { error: "Internal server error" },
      { status: 500 }
    );
  }
}
