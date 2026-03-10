import { redirect } from 'next/navigation';
import { createServerSupabase } from '@/lib/supabase/server';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { EmptyState } from '@/components/ui/empty-state';
import {
  Users,
  CalendarCheck,
  Award,
  MessageSquare,
  Megaphone,
  Sparkles,
  ChevronRight,
  GraduationCap,
} from 'lucide-react';
import Link from 'next/link';
import type { Student, Announcement } from '@/types';

export default async function ParentDashboard() {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) {
    redirect('/auth/login');
  }

  // Fetch children
  const { data: children } = await supabase
    .from('students')
    .select('*')
    .eq('parent_id', user.id)
    .eq('is_active', true)
    .order('full_name');

  const students: Student[] = children || [];

  // Fetch attendance stats per child (current month)
  const now = new Date();
  const monthStart = new Date(now.getFullYear(), now.getMonth(), 1)
    .toISOString()
    .split('T')[0];
  const monthEnd = new Date(now.getFullYear(), now.getMonth() + 1, 0)
    .toISOString()
    .split('T')[0];

  const studentIds = students.map((s) => s.id);

  const { data: attendanceRecords } = studentIds.length
    ? await supabase
        .from('attendance')
        .select('student_id, status')
        .in('student_id', studentIds)
        .gte('date', monthStart)
        .lte('date', monthEnd)
    : { data: [] };

  // Compute attendance percentage per student
  const attendanceByStudent: Record<
    string,
    { total: number; present: number }
  > = {};
  (attendanceRecords || []).forEach((r) => {
    if (!attendanceByStudent[r.student_id]) {
      attendanceByStudent[r.student_id] = { total: 0, present: 0 };
    }
    attendanceByStudent[r.student_id].total++;
    if (r.status === 'present' || r.status === 'late') {
      attendanceByStudent[r.student_id].present++;
    }
  });

  // Fetch latest grade averages per child
  const { data: gradeRecords } = studentIds.length
    ? await supabase
        .from('grades')
        .select('student_id, grade_percent')
        .in('student_id', studentIds)
    : { data: [] };

  const gradeAvgByStudent: Record<string, number> = {};
  const gradeCounts: Record<string, number> = {};
  (gradeRecords || []).forEach((g) => {
    if (g.grade_percent != null) {
      gradeAvgByStudent[g.student_id] =
        (gradeAvgByStudent[g.student_id] || 0) + g.grade_percent;
      gradeCounts[g.student_id] = (gradeCounts[g.student_id] || 0) + 1;
    }
  });
  Object.keys(gradeAvgByStudent).forEach((sid) => {
    gradeAvgByStudent[sid] = Math.round(
      gradeAvgByStudent[sid] / gradeCounts[sid]
    );
  });

  // Fetch announcements (latest 5)
  const { data: announcements } = await supabase
    .from('announcements')
    .select('*')
    .order('created_at', { ascending: false })
    .limit(5);

  const announcementList: Announcement[] = announcements || [];

  // Fetch unread messages count
  const { count: unreadCount } = await supabase
    .from('messages')
    .select('id', { count: 'exact', head: true })
    .eq('receiver_id', user.id)
    .eq('is_read', false);

  // Fetch AI tutor usage per child
  const { data: aiUsageData } = studentIds.length
    ? await supabase
        .from('ai_usage')
        .select('student_id, messages_sent')
        .in('student_id', studentIds)
    : { data: [] };

  const aiUsageByStudent: Record<string, number> = {};
  (aiUsageData || []).forEach((u) => {
    aiUsageByStudent[u.student_id] =
      (aiUsageByStudent[u.student_id] || 0) + u.messages_sent;
  });

  const today = new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });

  const { data: profile } = await supabase
    .from('profiles')
    .select('full_name')
    .eq('id', user.id)
    .single();

  const parentName = profile?.full_name || 'Parent';

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Welcome Banner */}
      <div className="bg-gradient-to-r from-[#003087] to-[#1D5FAF] rounded-2xl p-6 text-white">
        <div className="flex items-center justify-between flex-wrap gap-4">
          <div>
            <h1 className="font-heading text-2xl font-bold">
              Welcome, {parentName}!
            </h1>
            <p className="text-blue-200 mt-1 text-sm">{today}</p>
          </div>
          <div className="flex items-center gap-3">
            {students.length > 0 && (
              <Badge className="bg-white/20 text-white border-white/30 text-sm px-3 py-1">
                {students.length} {students.length === 1 ? 'Child' : 'Children'}
              </Badge>
            )}
            {(unreadCount ?? 0) > 0 && (
              <Link href="/parent/messages">
                <Badge className="bg-[#FFD100] text-[#1a1a2e] text-sm px-3 py-1 hover:bg-[#FFD100]/90 transition-colors">
                  <MessageSquare className="w-3.5 h-3.5 mr-1" />
                  {unreadCount} unread
                </Badge>
              </Link>
            )}
          </div>
        </div>
      </div>

      {/* Children Cards */}
      {students.length === 0 ? (
        <EmptyState icon={Users} message="No children linked to your account yet. Please contact the school administration." />
      ) : (
        <section>
          <h2 className="font-heading text-lg font-semibold text-[#1a1a2e] mb-3">
            Your Children
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {students.map((child) => {
              const att = attendanceByStudent[child.id];
              const attPercent = att
                ? Math.round((att.present / att.total) * 100)
                : null;
              const gradeAvg = gradeAvgByStudent[child.id] ?? null;
              const aiMessages = aiUsageByStudent[child.id] ?? 0;

              return (
                <Card
                  key={child.id}
                  className="hover:shadow-md transition-shadow"
                >
                  <CardContent className="p-5">
                    <div className="flex items-start justify-between mb-4">
                      <div className="flex items-center gap-3">
                        <div className="w-12 h-12 rounded-xl bg-[#003087]/10 flex items-center justify-center">
                          <GraduationCap className="w-6 h-6 text-[#003087]" />
                        </div>
                        <div>
                          <h3 className="font-semibold text-[#1a1a2e] text-base">
                            {child.full_name}
                          </h3>
                          <p className="text-sm text-[#5a6577]">
                            Grade {child.grade} - Section {child.section}
                          </p>
                        </div>
                      </div>
                    </div>

                    {/* Stats row */}
                    <div className="grid grid-cols-3 gap-3 mb-4">
                      <div className="bg-[#F5F7FB] rounded-xl p-3 text-center">
                        <CalendarCheck className="w-4 h-4 mx-auto mb-1 text-[#0A8F6C]" />
                        <p className="text-lg font-bold text-[#1a1a2e]">
                          {attPercent != null ? `${attPercent}%` : '--'}
                        </p>
                        <p className="text-xs text-[#5a6577]">Attendance</p>
                      </div>
                      <div className="bg-[#F5F7FB] rounded-xl p-3 text-center">
                        <Award className="w-4 h-4 mx-auto mb-1 text-[#003087]" />
                        <p className="text-lg font-bold text-[#1a1a2e]">
                          {gradeAvg != null ? `${gradeAvg}%` : '--'}
                        </p>
                        <p className="text-xs text-[#5a6577]">Grade Avg</p>
                      </div>
                      <div className="bg-[#F5F7FB] rounded-xl p-3 text-center">
                        <Sparkles className="w-4 h-4 mx-auto mb-1 text-[#F59E0B]" />
                        <p className="text-lg font-bold text-[#1a1a2e]">
                          {aiMessages}
                        </p>
                        <p className="text-xs text-[#5a6577]">AI Sessions</p>
                      </div>
                    </div>

                    {/* Quick links */}
                    <div className="flex flex-wrap gap-2">
                      <Link
                        href={`/parent/attendance?child=${child.id}`}
                        className="flex items-center gap-1 text-xs font-medium text-[#003087] hover:text-[#003087]/80 transition-colors bg-[#003087]/5 rounded-lg px-3 py-1.5"
                      >
                        <CalendarCheck className="w-3 h-3" />
                        Attendance
                        <ChevronRight className="w-3 h-3" />
                      </Link>
                      <Link
                        href={`/parent/grades?child=${child.id}`}
                        className="flex items-center gap-1 text-xs font-medium text-[#003087] hover:text-[#003087]/80 transition-colors bg-[#003087]/5 rounded-lg px-3 py-1.5"
                      >
                        <Award className="w-3 h-3" />
                        Grades
                        <ChevronRight className="w-3 h-3" />
                      </Link>
                      <Link
                        href={`/parent/profile?child=${child.id}`}
                        className="flex items-center gap-1 text-xs font-medium text-[#003087] hover:text-[#003087]/80 transition-colors bg-[#003087]/5 rounded-lg px-3 py-1.5"
                      >
                        <Sparkles className="w-3 h-3" />
                        AI Tutor Activity
                        <ChevronRight className="w-3 h-3" />
                      </Link>
                    </div>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        </section>
      )}

      {/* Announcements Feed */}
      <section>
        <div className="flex items-center justify-between mb-3">
          <h2 className="font-heading text-lg font-semibold text-[#1a1a2e]">
            Announcements
          </h2>
          <Link
            href="/parent/announcements"
            className="text-sm font-medium text-[#003087] hover:text-[#003087]/80 transition-colors"
          >
            View All
          </Link>
        </div>
        {announcementList.length === 0 ? (
          <EmptyState
            icon={Megaphone}
            message="No announcements at this time."
          />
        ) : (
          <div className="space-y-3">
            {announcementList.map((ann) => {
              const priorityColors: Record<string, string> = {
                normal: '#5a6577',
                important: '#F59E0B',
                urgent: '#E8443A',
              };
              const color = priorityColors[ann.priority] || '#5a6577';
              return (
                <Card
                  key={ann.id}
                  className="hover:shadow-md transition-shadow"
                >
                  <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                      <div
                        className="w-2 h-2 rounded-full mt-2 shrink-0"
                        style={{ backgroundColor: color }}
                      />
                      <div className="min-w-0 flex-1">
                        <div className="flex items-start justify-between gap-2">
                          <h3 className="font-semibold text-[#1a1a2e] text-sm">
                            {ann.title}
                          </h3>
                          {ann.priority !== 'normal' && (
                            <Badge
                              className={`text-xs shrink-0 ${
                                ann.priority === 'urgent'
                                  ? 'bg-[#E8443A]/10 text-[#E8443A]'
                                  : 'bg-[#F59E0B]/10 text-[#F59E0B]'
                              }`}
                            >
                              {ann.priority}
                            </Badge>
                          )}
                        </div>
                        {ann.message && (
                          <p className="text-xs text-[#5a6577] mt-1 line-clamp-2">
                            {ann.message}
                          </p>
                        )}
                        <p className="text-xs text-[#5a6577]/70 mt-1.5">
                          {new Date(ann.created_at).toLocaleDateString('en-PK', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric',
                          })}
                        </p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        )}
      </section>
    </div>
  );
}
