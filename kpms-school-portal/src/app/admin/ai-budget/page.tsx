"use client";

import { useEffect, useState, useCallback } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { LoadingState } from "@/components/ui/loading-state";
import { EmptyState } from "@/components/ui/empty-state";
import { createClient } from "@/lib/supabase/client";
import {
  DollarSign,
  TrendingUp,
  AlertTriangle,
  Zap,
  ZapOff,
  Users,
  Calendar,
  Save,
} from "lucide-react";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from "recharts";
import type { AIBudget, AIUsage } from "@/types";

interface DailySpend {
  date: string;
  cost: number;
}

interface StudentCost {
  student_id: string;
  student_name: string;
  total_cost: number;
  messages: number;
}

export default function AIBudgetPage() {
  const [budget, setBudget] = useState<AIBudget | null>(null);
  const [dailySpend, setDailySpend] = useState<DailySpend[]>([]);
  const [studentCosts, setStudentCosts] = useState<StudentCost[]>([]);
  const [loading, setLoading] = useState(true);
  const [newLimit, setNewLimit] = useState("");
  const [savingLimit, setSavingLimit] = useState(false);
  const [togglingAI, setTogglingAI] = useState(false);

  const currentMonth = new Date().toISOString().slice(0, 7);

  const fetchData = useCallback(async () => {
    const supabase = createClient();

    // Fetch budget
    const { data: budgetData } = await supabase
      .from("ai_budget")
      .select("*")
      .eq("month", currentMonth)
      .single();

    if (budgetData) {
      setBudget(budgetData as AIBudget);
      setNewLimit(String((budgetData.budget_limit_cents / 100).toFixed(2)));
    }

    // Fetch daily usage for current month
    const startOfMonth = `${currentMonth}-01`;
    const { data: usageData } = await supabase
      .from("ai_usage")
      .select("date, estimated_cost_cents, student_id, messages_sent")
      .gte("date", startOfMonth)
      .order("date", { ascending: true });

    if (usageData && usageData.length > 0) {
      // Aggregate daily spend
      const dailyMap = new Map<string, number>();
      (usageData as AIUsage[]).forEach((u) => {
        const existing = dailyMap.get(u.date) || 0;
        dailyMap.set(u.date, existing + u.estimated_cost_cents);
      });
      const dailyArr: DailySpend[] = Array.from(dailyMap.entries())
        .map(([date, cost]) => ({
          date: new Date(date).toLocaleDateString("en-US", { month: "short", day: "numeric" }),
          cost: cost / 100,
        }))
        .sort((a, b) => a.date.localeCompare(b.date));
      setDailySpend(dailyArr);

      // Aggregate per-student costs
      const studentMap = new Map<string, { cost: number; messages: number }>();
      (usageData as AIUsage[]).forEach((u) => {
        const existing = studentMap.get(u.student_id) || { cost: 0, messages: 0 };
        studentMap.set(u.student_id, {
          cost: existing.cost + u.estimated_cost_cents,
          messages: existing.messages + u.messages_sent,
        });
      });

      // Fetch student names
      const studentIds = Array.from(studentMap.keys());
      const { data: studentsData } = await supabase
        .from("students")
        .select("id, full_name")
        .in("id", studentIds);

      const nameMap = new Map<string, string>();
      (studentsData || []).forEach((s: { id: string; full_name: string }) => {
        nameMap.set(s.id, s.full_name);
      });

      const costs: StudentCost[] = Array.from(studentMap.entries())
        .map(([id, data]) => ({
          student_id: id,
          student_name: nameMap.get(id) || "Unknown",
          total_cost: data.cost / 100,
          messages: data.messages,
        }))
        .sort((a, b) => b.total_cost - a.total_cost);
      setStudentCosts(costs);
    }

    setLoading(false);
  }, [currentMonth]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  const spent = budget ? budget.spent_cents / 100 : 0;
  const limit = budget ? budget.budget_limit_cents / 100 : 25;
  const pct = limit > 0 ? Math.min((spent / limit) * 100, 100) : 0;

  // Projected spend
  const today = new Date();
  const dayOfMonth = today.getDate();
  const daysInMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
  const dailyAvg = dayOfMonth > 0 ? spent / dayOfMonth : 0;
  const projected = dailyAvg * daysInMonth;
  const projectedExceeds = projected > limit;

  let barColor = "#0A8F6C";
  if (pct > 80) barColor = "#E8443A";
  else if (pct > 50) barColor = "#F59E0B";

  async function handleSaveLimit() {
    if (!budget) return;
    setSavingLimit(true);
    const supabase = createClient();
    const newCents = Math.round(parseFloat(newLimit) * 100);
    const { error } = await supabase
      .from("ai_budget")
      .update({ budget_limit_cents: newCents })
      .eq("id", budget.id);

    if (!error) {
      setBudget({ ...budget, budget_limit_cents: newCents });
    }
    setSavingLimit(false);
  }

  async function toggleAITutor() {
    if (!budget) return;
    setTogglingAI(true);
    const supabase = createClient();
    const newState = !budget.is_budget_exceeded;
    const { error } = await supabase
      .from("ai_budget")
      .update({ is_budget_exceeded: newState })
      .eq("id", budget.id);

    if (!error) {
      setBudget({ ...budget, is_budget_exceeded: newState });
    }
    setTogglingAI(false);
  }

  if (loading) {
    return <LoadingState message="Loading AI budget data..." />;
  }

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div>
        <h1 className="font-heading text-2xl font-bold text-foreground">
          AI Budget Monitor
        </h1>
        <p className="text-sm text-muted-foreground mt-1">
          Track and manage AI tutor spending for {new Date().toLocaleDateString("en-US", { month: "long", year: "numeric" })}
        </p>
      </div>

      {/* Alert Banner */}
      {projectedExceeds && !budget?.is_budget_exceeded && (
        <div className="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#F59E0B]/10 border border-[#F59E0B]/30 text-sm">
          <AlertTriangle className="w-5 h-5 text-[#F59E0B] shrink-0" />
          <div>
            <span className="font-semibold text-[#92400e]">Budget Alert: </span>
            <span className="text-[#92400e]">
              At the current rate, projected spend is ${projected.toFixed(2)} which exceeds the ${limit.toFixed(2)} budget.
            </span>
          </div>
        </div>
      )}

      {budget?.is_budget_exceeded && (
        <div className="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/30 text-sm">
          <ZapOff className="w-5 h-5 text-[#E8443A] shrink-0" />
          <div>
            <span className="font-semibold text-[#E8443A]">AI Tutor Disabled: </span>
            <span className="text-[#991b1b]">
              AI tutoring has been manually disabled. Students cannot access the AI tutor.
            </span>
          </div>
        </div>
      )}

      {/* Big Spend Display + Controls */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Main Spend Card */}
        <Card className="lg:col-span-2">
          <CardContent className="p-6 space-y-4">
            <div className="flex items-center gap-3 mb-2">
              <div className="w-12 h-12 rounded-xl bg-[#003087]/10 flex items-center justify-center">
                <DollarSign className="w-6 h-6 text-[#003087]" />
              </div>
              <div>
                <p className="text-sm text-muted-foreground">Current Month Spend</p>
                <div className="flex items-baseline gap-2">
                  <span className="text-4xl font-bold text-foreground">
                    ${spent.toFixed(2)}
                  </span>
                  <span className="text-lg text-muted-foreground">
                    of ${limit.toFixed(2)}
                  </span>
                </div>
              </div>
            </div>
            <div className="w-full h-4 rounded-full bg-[#e2e8f0] overflow-hidden">
              <div
                className="h-full rounded-full transition-all duration-700"
                style={{ width: `${pct}%`, backgroundColor: barColor }}
              />
            </div>
            <div className="flex items-center justify-between text-sm">
              <span className="text-muted-foreground">{pct.toFixed(1)}% used</span>
              <span className="text-muted-foreground">
                ${(limit - spent > 0 ? limit - spent : 0).toFixed(2)} remaining
              </span>
            </div>

            {/* Projected */}
            <div className="flex items-center gap-3 pt-2 border-t border-[#e2e8f0]">
              <TrendingUp className="w-5 h-5 text-[#5a6577]" />
              <div>
                <p className="text-sm font-medium text-foreground">
                  Projected month-end: ${projected.toFixed(2)}
                </p>
                <p className="text-xs text-muted-foreground">
                  Based on ${dailyAvg.toFixed(2)}/day average over {dayOfMonth} day{dayOfMonth !== 1 ? "s" : ""}
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Controls Card */}
        <Card>
          <CardContent className="p-6 space-y-5">
            {/* Adjust Budget */}
            <div className="space-y-2">
              <Label htmlFor="budget-limit" className="text-sm font-semibold">
                Adjust Budget
              </Label>
              <div className="flex gap-2">
                <div className="relative flex-1">
                  <span className="absolute left-2.5 top-1/2 -translate-y-1/2 text-sm text-muted-foreground">$</span>
                  <Input
                    id="budget-limit"
                    type="number"
                    step="0.01"
                    min="0"
                    value={newLimit}
                    onChange={(e) => setNewLimit(e.target.value)}
                    className="pl-6"
                  />
                </div>
                <Button
                  onClick={handleSaveLimit}
                  disabled={savingLimit}
                  size="default"
                  className="gap-1.5"
                >
                  <Save className="w-4 h-4" />
                  {savingLimit ? "..." : "Save"}
                </Button>
              </div>
            </div>

            {/* Emergency Toggle */}
            <div className="space-y-2 pt-3 border-t border-[#e2e8f0]">
              <Label className="text-sm font-semibold">Emergency Controls</Label>
              <Button
                variant={budget?.is_budget_exceeded ? "outline" : "destructive"}
                className="w-full gap-2"
                onClick={toggleAITutor}
                disabled={togglingAI}
              >
                {budget?.is_budget_exceeded ? (
                  <>
                    <Zap className="w-4 h-4" />
                    {togglingAI ? "Enabling..." : "Enable AI Tutor"}
                  </>
                ) : (
                  <>
                    <ZapOff className="w-4 h-4" />
                    {togglingAI ? "Disabling..." : "Disable AI Tutor"}
                  </>
                )}
              </Button>
              <p className="text-xs text-muted-foreground">
                {budget?.is_budget_exceeded
                  ? "AI Tutor is currently disabled. Click to re-enable."
                  : "Immediately blocks all AI tutor access for students."}
              </p>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Daily Spend Chart */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2 text-base font-semibold">
            <Calendar className="w-5 h-5 text-[#003087]" />
            Daily Spend Trend
          </CardTitle>
        </CardHeader>
        <CardContent>
          {dailySpend.length === 0 ? (
            <EmptyState icon={<TrendingUp className="h-12 w-12" />} message="No spending data for this month yet." />
          ) : (
            <div className="w-full h-[300px]">
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={dailySpend} margin={{ top: 5, right: 20, bottom: 5, left: 0 }}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" />
                  <XAxis
                    dataKey="date"
                    tick={{ fontSize: 12, fill: "#5a6577" }}
                    tickLine={false}
                    axisLine={{ stroke: "#e2e8f0" }}
                  />
                  <YAxis
                    tick={{ fontSize: 12, fill: "#5a6577" }}
                    tickLine={false}
                    axisLine={{ stroke: "#e2e8f0" }}
                    tickFormatter={(v) => `$${v}`}
                  />
                  <Tooltip
                    contentStyle={{
                      backgroundColor: "#fff",
                      border: "1px solid #e2e8f0",
                      borderRadius: "12px",
                      fontSize: "13px",
                    }}
                    formatter={(value) => [`$${Number(value).toFixed(2)}`, "Cost"]}
                  />
                  <Line
                    type="monotone"
                    dataKey="cost"
                    stroke="#003087"
                    strokeWidth={2}
                    dot={{ fill: "#003087", r: 3 }}
                    activeDot={{ r: 5, fill: "#003087" }}
                  />
                </LineChart>
              </ResponsiveContainer>
            </div>
          )}
        </CardContent>
      </Card>

      {/* Per-Student Breakdown */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2 text-base font-semibold">
            <Users className="w-5 h-5 text-[#003087]" />
            Per-Student Cost Breakdown
          </CardTitle>
        </CardHeader>
        <CardContent className="p-0">
          {studentCosts.length === 0 ? (
            <div className="p-6">
              <EmptyState icon={<Users className="h-12 w-12" />} message="No per-student data available yet." />
            </div>
          ) : (
            <>
              <div className="hidden md:grid grid-cols-[2fr_1fr_1fr_1fr] gap-4 px-4 py-3 bg-[#F5F7FB] border-b border-[#e2e8f0] text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
                <span>Student</span>
                <span>Messages</span>
                <span>Cost</span>
                <span>% of Total</span>
              </div>
              <div className="divide-y divide-[#e2e8f0]">
                {studentCosts.map((sc) => {
                  const costPct = spent > 0 ? (sc.total_cost / spent) * 100 : 0;
                  return (
                    <div
                      key={sc.student_id}
                      className="flex flex-col md:grid md:grid-cols-[2fr_1fr_1fr_1fr] gap-2 md:gap-4 items-start md:items-center px-4 py-3 hover:bg-muted/50 transition-colors"
                    >
                      <span className="font-medium text-foreground text-sm">
                        {sc.student_name}
                      </span>
                      <span className="text-sm text-muted-foreground">
                        {sc.messages.toLocaleString()}
                      </span>
                      <span className="text-sm font-medium text-foreground">
                        ${sc.total_cost.toFixed(2)}
                      </span>
                      <div className="flex items-center gap-2 w-full">
                        <div className="flex-1 h-2 rounded-full bg-[#e2e8f0] overflow-hidden">
                          <div
                            className="h-full rounded-full bg-[#003087]"
                            style={{ width: `${Math.min(costPct, 100)}%` }}
                          />
                        </div>
                        <span className="text-xs text-muted-foreground w-10 text-right">
                          {costPct.toFixed(1)}%
                        </span>
                      </div>
                    </div>
                  );
                })}
              </div>
            </>
          )}
        </CardContent>
      </Card>
    </div>
  );
}
