import { redirect } from "next/navigation";
import { createServerSupabase } from "@/lib/supabase/server";
import { getGradeColor } from "@/lib/utils";
import { Award } from "lucide-react";
import type { GradeRecord } from "@/types";
import { GradeTermTabs } from "./grade-term-tabs";

export default async function StudentGradesPage() {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) {
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

  // Fetch all grades for the student
  const { data: grades } = await supabase
    .from("grades")
    .select("*")
    .eq("student_id", studentId)
    .order("subject", { ascending: true });

  // Group grades by term
  const allGrades: GradeRecord[] = grades || [];
  const terms = [...new Set(allGrades.map((g) => g.term))].sort();

  // If no terms, provide defaults
  const availableTerms =
    terms.length > 0 ? terms : ["Term 1", "Term 2", "Final"];

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div className="flex items-center gap-3">
        <div className="w-10 h-10 rounded-xl bg-[#003087]/10 flex items-center justify-center">
          <Award className="w-5 h-5 text-[#003087]" />
        </div>
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            My Grades
          </h1>
          <p className="text-sm text-[#5a6577]">
            View your academic performance
          </p>
        </div>
      </div>

      <GradeTermTabs terms={availableTerms} grades={allGrades} />
    </div>
  );
}
