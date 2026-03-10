import { redirect } from 'next/navigation';
import { createServerSupabase } from '@/lib/supabase/server';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { EmptyState } from '@/components/ui/empty-state';
import {
  Users,
  GraduationCap,
  Calendar,
  Droplets,
  BookOpen,
  Sparkles,
  Clock,
  MessageSquare,
  Brain,
  TrendingUp,
} from 'lucide-react';
import { formatDate } from '@/lib/utils';
import type { Student, AIEngagement } from '@/types';
import { ProfileChildSelector } from './profile-client';

export default async function ChildProfilePage({
  searchParams,
}: {
  searchParams: Promise<{ child?: string }>;
}) {
  const supabase = await createServerSupabase();
  const params = await searchParams;

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) {
    redirect('/auth/login');
  }

  // Fetch children
  const { data: childrenData } = await supabase
    .from('students')
    .select('*')
    .eq('parent_id', user.id)
    .eq('is_active', true)
    .order('full_name');

  const children: Student[] = childrenData || [];

  if (children.length === 0) {
    return (
      <div className="max-w-4xl">
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e] mb-4">
          Child Profile
        </h1>
        <EmptyState
          icon={Users}
          message="No children linked to your account."
        />
      </div>
    );
  }

  // Determine selected child
  const selectedChildId =
    params.child && children.some((c) => c.id === params.child)
      ? params.child
      : children[0].id;

  const child = children.find((c) => c.id === selectedChildId)!;

  // Fetch AI usage stats (aggregate)
  const { data: aiUsageData } = await supabase
    .from('ai_usage')
    .select('messages_sent, input_tokens, output_tokens, voice_minutes')
    .eq('student_id', selectedChildId);

  const aiUsageStats = {
    totalSessions: aiUsageData?.length || 0,
    totalMessages: (aiUsageData || []).reduce(
      (sum, u) => sum + (u.messages_sent || 0),
      0
    ),
    totalVoiceMinutes: (aiUsageData || []).reduce(
      (sum, u) => sum + (u.voice_minutes || 0),
      0
    ),
  };

  // Fetch AI engagement data
  const { data: engagementData } = await supabase
    .from('ai_engagement')
    .select('subject, messages_in_session, questions_asked, engagement_score, topics_covered')
    .eq('student_id', selectedChildId)
    .order('created_at', { ascending: false })
    .limit(20);

  const engagementList: AIEngagement[] = (engagementData || []) as AIEngagement[];

  // Aggregate engagement by subject
  const subjectEngagement: Record<
    string,
    { sessions: number; questions: number; avgScore: number; topics: Set<string> }
  > = {};
  engagementList.forEach((e) => {
    const subj = e.subject || 'General';
    if (!subjectEngagement[subj]) {
      subjectEngagement[subj] = { sessions: 0, questions: 0, avgScore: 0, topics: new Set() };
    }
    subjectEngagement[subj].sessions++;
    subjectEngagement[subj].questions += e.questions_asked || 0;
    subjectEngagement[subj].avgScore += e.engagement_score || 0;
    (e.topics_covered || []).forEach((t) => subjectEngagement[subj].topics.add(t));
  });

  Object.keys(subjectEngagement).forEach((subj) => {
    const s = subjectEngagement[subj];
    s.avgScore = s.sessions > 0 ? Math.round(s.avgScore / s.sessions) : 0;
  });

  // Convert for serialization
  const subjectEngagementSerialized = Object.entries(subjectEngagement).map(
    ([subject, data]) => ({
      subject,
      sessions: data.sessions,
      questions: data.questions,
      avgScore: data.avgScore,
      topicCount: data.topics.size,
    })
  );

  // Fetch conversation count
  const { count: conversationCount } = await supabase
    .from('ai_conversations')
    .select('id', { count: 'exact', head: true })
    .eq('student_id', selectedChildId);

  const infoItems = [
    { label: 'Full Name', value: child.full_name, icon: Users },
    { label: 'Grade', value: child.grade, icon: GraduationCap },
    { label: 'Section', value: child.section, icon: BookOpen },
    {
      label: 'Date of Birth',
      value: child.date_of_birth ? formatDate(child.date_of_birth) : 'Not set',
      icon: Calendar,
    },
    {
      label: 'Enrollment Date',
      value: formatDate(child.enrollment_date),
      icon: Calendar,
    },
    {
      label: 'Blood Group',
      value: child.blood_group || 'Not set',
      icon: Droplets,
    },
  ];

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header with child selector */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            Child Profile
          </h1>
          <p className="text-sm text-[#5a6577] mt-1">
            Student details and AI tutor activity
          </p>
        </div>
        {children.length > 1 && (
          <ProfileChildSelector
            studentList={children}
            selectedChildId={selectedChildId}
          />
        )}
      </div>

      {/* Student Info Card */}
      <Card>
        <CardContent className="p-6">
          <div className="flex items-center gap-4 mb-6">
            <div className="w-16 h-16 rounded-2xl bg-[#003087]/10 flex items-center justify-center">
              <GraduationCap className="w-8 h-8 text-[#003087]" />
            </div>
            <div>
              <h2 className="font-heading text-xl font-bold text-[#1a1a2e]">
                {child.full_name}
              </h2>
              <p className="text-sm text-[#5a6577]">
                Grade {child.grade} - Section {child.section}
              </p>
              <Badge className="mt-1 bg-[#0A8F6C]/10 text-[#0A8F6C]">
                Active Student
              </Badge>
            </div>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {infoItems.map((item) => {
              const Icon = item.icon;
              return (
                <div
                  key={item.label}
                  className="flex items-center gap-3 bg-[#F5F7FB] rounded-xl p-3"
                >
                  <Icon className="w-4 h-4 text-[#5a6577] shrink-0" />
                  <div>
                    <p className="text-xs text-[#5a6577]">{item.label}</p>
                    <p className="text-sm font-medium text-[#1a1a2e]">
                      {item.value}
                    </p>
                  </div>
                </div>
              );
            })}
          </div>
        </CardContent>
      </Card>

      {/* AI Tutor Activity Summary */}
      <section>
        <h2 className="font-heading text-lg font-semibold text-[#1a1a2e] mb-3">
          AI Tutor Activity
        </h2>
        <p className="text-xs text-[#5a6577] mb-4">
          Usage statistics and engagement summary. Conversation content is private to the student.
        </p>

        {/* Stats cards */}
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
          <Card>
            <CardContent className="p-4 text-center">
              <Sparkles className="w-5 h-5 mx-auto mb-1 text-[#F59E0B]" />
              <p className="text-xl font-bold text-[#1a1a2e]">
                {conversationCount || 0}
              </p>
              <p className="text-xs text-[#5a6577]">Conversations</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 text-center">
              <MessageSquare className="w-5 h-5 mx-auto mb-1 text-[#003087]" />
              <p className="text-xl font-bold text-[#1a1a2e]">
                {aiUsageStats.totalMessages}
              </p>
              <p className="text-xs text-[#5a6577]">Messages Sent</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 text-center">
              <Clock className="w-5 h-5 mx-auto mb-1 text-[#0A8F6C]" />
              <p className="text-xl font-bold text-[#1a1a2e]">
                {aiUsageStats.totalSessions}
              </p>
              <p className="text-xs text-[#5a6577]">Active Days</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 text-center">
              <Brain className="w-5 h-5 mx-auto mb-1 text-[#8B5CF6]" />
              <p className="text-xl font-bold text-[#1a1a2e]">
                {Math.round(aiUsageStats.totalVoiceMinutes)}
              </p>
              <p className="text-xs text-[#5a6577]">Voice Minutes</p>
            </CardContent>
          </Card>
        </div>

        {/* Subject Engagement Breakdown */}
        {subjectEngagementSerialized.length > 0 ? (
          <Card>
            <CardContent className="p-5">
              <h3 className="text-sm font-semibold text-[#1a1a2e] mb-4 flex items-center gap-2">
                <TrendingUp className="w-4 h-4 text-[#003087]" />
                Subjects Studied with AI Tutor
              </h3>
              <div className="space-y-3">
                {subjectEngagementSerialized.map((entry) => (
                  <div
                    key={entry.subject}
                    className="flex items-center justify-between bg-[#F5F7FB] rounded-xl p-3"
                  >
                    <div className="flex items-center gap-3">
                      <BookOpen className="w-4 h-4 text-[#003087]" />
                      <div>
                        <p className="text-sm font-medium text-[#1a1a2e]">
                          {entry.subject}
                        </p>
                        <p className="text-xs text-[#5a6577]">
                          {entry.sessions} session{entry.sessions !== 1 ? 's' : ''}{' '}
                          &middot; {entry.questions} question{entry.questions !== 1 ? 's' : ''}{' '}
                          &middot; {entry.topicCount} topic{entry.topicCount !== 1 ? 's' : ''}
                        </p>
                      </div>
                    </div>
                    {entry.avgScore > 0 && (
                      <div className="text-right">
                        <p className="text-sm font-bold text-[#003087]">
                          {entry.avgScore}/10
                        </p>
                        <p className="text-xs text-[#5a6577]">Engagement</p>
                      </div>
                    )}
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        ) : (
          <EmptyState
            icon={Sparkles}
            message="No AI tutor activity recorded yet."
          />
        )}
      </section>
    </div>
  );
}
