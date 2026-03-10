import { createServerSupabase } from "@/lib/supabase/server";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import {
  BarChart3,
  GraduationCap,
  Users,
  BookOpen,
  School,
  CalendarCheck,
  DollarSign,
  AlertTriangle,
} from "lucide-react";
import type { AIBudget } from "@/types";

async function getDashboardStats() {
  const supabase = await createServerSupabase();

  const [
    { count: studentCount },
    { count: teacherCount },
    { count: parentCount },
    { count: classCount },
    { data: attendanceData },
    { data: aiBudget },
  ] = await Promise.all([
    supabase.from("students").select("*", { count: "exact", head: true }).eq("is_active", true),
    supabase.from("profiles").select("*", { count: "exact", head: true }).eq("role", "teacher"),
    supabase.from("profiles").select("*", { count: "exact", head: true }).eq("role", "parent"),
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
  ]);

  const totalRecords = attendanceData?.length || 0;
  const presentRecords = attendanceData?.filter((r) => r.status === "present" || r.status === "late").length || 0;
  const attendanceRate = totalRecords > 0 ? Math.round((presentRecords / totalRecords) * 100) : 0;

  return {
    studentCount: studentCount || 0,
    teacherCount: teacherCount || 0,
    parentCount: parentCount || 0,
    classCount: classCount || 0,
    attendanceRate,
    aiBudget: aiBudget as AIBudget | null,
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

export default async function DashboardPage() {
  const stats = await getDashboardStats();

  const spent = stats.aiBudget ? stats.aiBudget.spent_cents / 100 : 0;
  const limit = stats.aiBudget ? stats.aiBudget.budget_limit_cents / 100 : 25;
  const pct = limit > 0 ? Math.min((spent / limit) * 100, 100) : 0;

  let barColor = "#0A8F6C";
  if (pct > 80) barColor = "#E8443A";
  else if (pct > 50) barColor = "#F59E0B";

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div className="bg-gradient-to-r from-[#003087] to-[#001a4d] rounded-2xl p-6 text-white">
        <div className="flex items-center justify-between flex-wrap gap-4">
          <div className="flex items-center gap-3">
            <BarChart3 className="w-7 h-7 text-[#FFD100]" />
            <div>
              <h1 className="font-heading text-2xl font-bold">Dashboard</h1>
              <p className="text-blue-200 mt-1 text-sm">School analytics and statistics</p>
            </div>
          </div>
          <Badge className="bg-[#FFD100] text-[#003087] border-0 text-sm px-3 py-1 font-semibold">
            Analytics
          </Badge>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <StatCard icon={GraduationCap} label="Total Students" value={stats.studentCount} color="#003087" />
        <StatCard icon={BookOpen} label="Total Teachers" value={stats.teacherCount} color="#F59E0B" />
        <StatCard icon={Users} label="Total Parents" value={stats.parentCount} color="#0A8F6C" />
        <StatCard icon={School} label="Total Classes" value={stats.classCount} color="#8B5CF6" />
        <StatCard icon={CalendarCheck} label="Attendance Rate (30d)" value={`${stats.attendanceRate}%`} color="#059669" />

        {/* AI Budget Card */}
        <Card className="hover:shadow-md transition-shadow">
          <CardContent className="p-5">
            <div className="flex items-center gap-4">
              <div
                className="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                style={{ backgroundColor: `${barColor}15` }}
              >
                <DollarSign className="w-6 h-6" style={{ color: barColor }} />
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-baseline justify-between">
                  <p className="text-2xl font-bold text-foreground">${spent.toFixed(2)}</p>
                  <span className="text-xs text-muted-foreground">/ ${limit.toFixed(2)}</span>
                </div>
                <p className="text-sm text-muted-foreground">AI Budget Used</p>
                <div className="w-full h-1.5 rounded-full bg-[#e2e8f0] overflow-hidden mt-2">
                  <div
                    className="h-full rounded-full transition-all duration-500"
                    style={{ width: `${pct}%`, backgroundColor: barColor }}
                  />
                </div>
              </div>
            </div>
            {stats.aiBudget?.is_budget_exceeded && (
              <div className="flex items-center gap-2 text-xs text-[#E8443A] bg-red-50 rounded-lg px-3 py-2 mt-3">
                <AlertTriangle className="w-3.5 h-3.5" />
                Budget exceeded
              </div>
            )}
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
