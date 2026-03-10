import { createServerSupabase } from "@/lib/supabase/server";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import {
  GraduationCap,
  Users,
  BookOpen,
  UserCheck,
  CalendarCheck,
  DollarSign,
  Activity,
  Megaphone,
  CheckCircle2,
  AlertTriangle,
} from "lucide-react";
import { formatDate } from "@/lib/utils";
import type { AIBudget, Announcement } from "@/types";

async function getAdminStats() {
  const supabase = await createServerSupabase();

  const [
    { count: studentCount },
    { count: parentCount },
    { count: teacherCount },
    { count: classCount },
    { data: attendanceData },
    { data: aiBudget },
    { data: announcements },
  ] = await Promise.all([
    supabase.from("students").select("*", { count: "exact", head: true }).eq("is_active", true),
    supabase.from("profiles").select("*", { count: "exact", head: true }).eq("role", "parent"),
    supabase.from("profiles").select("*", { count: "exact", head: true }).eq("role", "teacher"),
    supabase.from("classes").select("*", { count: "exact", head: true }),
    supabase
      .from("attendance_records")
      .select("status")
      .gte("date", new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split("T")[0]),
    supabase
      .from("ai_budget")
      .select("*")
      .eq("month", new Date().toISOString().slice(0, 7))
      .single(),
    supabase
      .from("announcements")
      .select("*")
      .order("created_at", { ascending: false })
      .limit(4),
  ]);

  const totalRecords = attendanceData?.length || 0;
  const presentRecords = attendanceData?.filter((r) => r.status === "present" || r.status === "late").length || 0;
  const attendanceRate = totalRecords > 0 ? Math.round((presentRecords / totalRecords) * 100) : 0;

  return {
    studentCount: studentCount || 0,
    parentCount: parentCount || 0,
    teacherCount: teacherCount || 0,
    classCount: classCount || 0,
    attendanceRate,
    aiBudget: aiBudget as AIBudget | null,
    announcements: (announcements || []) as Announcement[],
  };
}

function StatCard({
  icon: Icon,
  label,
  value,
  color,
}: {
  icon: React.ComponentType<{ className?: string; style?: React.CSSProperties }>;
  label: string;
  value: string | number;
  color: string;
}) {
  return (
    <Card className="hover:shadow-md transition-shadow">
      <CardContent className="flex items-center gap-4 p-5">
        <div
          className="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
          style={{ backgroundColor: `${color}15` }}
        >
          <Icon className="w-6 h-6" style={{ color }} />
        </div>
        <div>
          <p className="text-2xl font-bold text-foreground">{value}</p>
          <p className="text-sm text-muted-foreground">{label}</p>
        </div>
      </CardContent>
    </Card>
  );
}

function BudgetCard({ budget }: { budget: AIBudget | null }) {
  const spent = budget ? budget.spent_cents / 100 : 0;
  const limit = budget ? budget.budget_limit_cents / 100 : 25;
  const pct = limit > 0 ? Math.min((spent / limit) * 100, 100) : 0;

  let barColor = "#0A8F6C";
  if (pct > 80) barColor = "#E8443A";
  else if (pct > 50) barColor = "#F59E0B";

  return (
    <Card className="hover:shadow-md transition-shadow">
      <CardHeader className="pb-2">
        <CardTitle className="flex items-center gap-2 text-base font-semibold">
          <DollarSign className="w-5 h-5 text-[#003087]" />
          AI Budget Status
        </CardTitle>
      </CardHeader>
      <CardContent className="space-y-3">
        <div className="flex items-baseline justify-between">
          <span className="text-2xl font-bold text-foreground">${spent.toFixed(2)}</span>
          <span className="text-sm text-muted-foreground">of ${limit.toFixed(2)}</span>
        </div>
        <div className="w-full h-2.5 rounded-full bg-[#e2e8f0] overflow-hidden">
          <div
            className="h-full rounded-full transition-all duration-500"
            style={{ width: `${pct}%`, backgroundColor: barColor }}
          />
        </div>
        <p className="text-xs text-muted-foreground">{pct.toFixed(0)}% of monthly budget used</p>
        {budget?.is_budget_exceeded && (
          <div className="flex items-center gap-2 text-xs text-[#E8443A] bg-red-50 rounded-lg px-3 py-2">
            <AlertTriangle className="w-3.5 h-3.5" />
            Budget exceeded - AI Tutor disabled
          </div>
        )}
      </CardContent>
    </Card>
  );
}

function SystemHealthCard() {
  return (
    <Card className="hover:shadow-md transition-shadow">
      <CardHeader className="pb-2">
        <CardTitle className="flex items-center gap-2 text-base font-semibold">
          <Activity className="w-5 h-5 text-[#003087]" />
          System Health
        </CardTitle>
      </CardHeader>
      <CardContent className="space-y-3">
        <div className="flex items-center justify-between">
          <span className="text-sm text-muted-foreground">Portal Status</span>
          <div className="flex items-center gap-1.5">
            <span className="w-2 h-2 rounded-full bg-[#0A8F6C] animate-pulse" />
            <span className="text-sm font-medium text-[#0A8F6C]">Online</span>
          </div>
        </div>
        <div className="flex items-center justify-between">
          <span className="text-sm text-muted-foreground">Database</span>
          <div className="flex items-center gap-1.5">
            <span className="w-2 h-2 rounded-full bg-[#0A8F6C]" />
            <span className="text-sm font-medium text-[#0A8F6C]">Connected</span>
          </div>
        </div>
        <div className="flex items-center justify-between">
          <span className="text-sm text-muted-foreground">AI Service</span>
          <div className="flex items-center gap-1.5">
            <span className="w-2 h-2 rounded-full bg-[#0A8F6C]" />
            <span className="text-sm font-medium text-[#0A8F6C]">Active</span>
          </div>
        </div>
        <div className="flex items-center justify-between">
          <span className="text-sm text-muted-foreground">Auth</span>
          <div className="flex items-center gap-1.5">
            <span className="w-2 h-2 rounded-full bg-[#0A8F6C]" />
            <span className="text-sm font-medium text-[#0A8F6C]">Healthy</span>
          </div>
        </div>
      </CardContent>
    </Card>
  );
}

const priorityColors: Record<string, string> = {
  normal: "#5a6577",
  important: "#F59E0B",
  urgent: "#E8443A",
};

export default async function AdminOverviewPage() {
  const stats = await getAdminStats();
  const today = new Date().toLocaleDateString("en-US", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Welcome Banner */}
      <div className="bg-gradient-to-r from-[#003087] to-[#001a4d] rounded-2xl p-6 text-white">
        <div className="flex items-center justify-between flex-wrap gap-4">
          <div>
            <h1 className="font-heading text-2xl font-bold">Admin Overview</h1>
            <p className="text-blue-200 mt-1 text-sm">{today}</p>
          </div>
          <Badge className="bg-[#FFD100] text-[#003087] border-0 text-sm px-3 py-1 font-semibold">
            Administrator
          </Badge>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <StatCard icon={GraduationCap} label="Total Students" value={stats.studentCount} color="#003087" />
        <StatCard icon={Users} label="Parents" value={stats.parentCount} color="#0A8F6C" />
        <StatCard icon={BookOpen} label="Teachers" value={stats.teacherCount} color="#F59E0B" />
        <StatCard icon={UserCheck} label="Classes" value={stats.classCount} color="#8B5CF6" />
        <StatCard icon={CalendarCheck} label="Attendance Rate" value={`${stats.attendanceRate}%`} color="#059669" />
      </div>

      {/* Two-column: Budget + System Health */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <BudgetCard budget={stats.aiBudget} />
        <SystemHealthCard />
      </div>

      {/* Recent Announcements */}
      <section>
        <div className="flex items-center gap-2 mb-4">
          <Megaphone className="w-5 h-5 text-[#003087]" />
          <h2 className="font-heading text-lg font-semibold text-foreground">Recent Announcements</h2>
        </div>
        {stats.announcements.length === 0 ? (
          <Card>
            <CardContent className="flex flex-col items-center justify-center py-12 text-center">
              <Megaphone className="w-12 h-12 text-muted-foreground/40 mb-3" />
              <p className="text-sm text-muted-foreground">No announcements yet.</p>
            </CardContent>
          </Card>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {stats.announcements.map((ann) => (
              <Card key={ann.id} className="hover:shadow-md transition-shadow">
                <CardContent className="p-5">
                  <div className="flex items-start gap-3">
                    <div
                      className="w-2 h-2 rounded-full mt-2 shrink-0"
                      style={{ backgroundColor: priorityColors[ann.priority] || "#5a6577" }}
                    />
                    <div className="min-w-0 flex-1">
                      <div className="flex items-center justify-between gap-2">
                        <h3 className="font-semibold text-foreground">{ann.title}</h3>
                        <Badge
                          variant="secondary"
                          className="text-[10px] shrink-0 capitalize"
                        >
                          {ann.priority}
                        </Badge>
                      </div>
                      {ann.message && (
                        <p className="text-sm text-muted-foreground mt-1 line-clamp-2">
                          {ann.message}
                        </p>
                      )}
                      <p className="text-xs text-muted-foreground mt-2">
                        {formatDate(ann.created_at)}
                      </p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        )}
      </section>
    </div>
  );
}
