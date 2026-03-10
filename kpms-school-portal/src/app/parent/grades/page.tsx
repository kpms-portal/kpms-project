import { redirect } from 'next/navigation';
import { createServerSupabase } from '@/lib/supabase/server';
import { EmptyState } from '@/components/ui/empty-state';
import { Award } from 'lucide-react';
import type { Student, GradeRecord } from '@/types';
import { GradesClientView } from './grades-client';

export default async function GradesPage({
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
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e] mb-4">Grades</h1>
        <EmptyState icon={Award} message="No children linked to your account." />
      </div>
    );
  }

  // Determine selected child
  const selectedChildId = params.child && children.some((c) => c.id === params.child)
    ? params.child
    : children[0].id;

  const selectedStudent = children.find((c) => c.id === selectedChildId)!;

  // Fetch grades for selected child
  const { data: gradesData } = await supabase
    .from('grades')
    .select('*')
    .eq('student_id', selectedChildId)
    .order('subject');

  const grades: GradeRecord[] = gradesData || [];

  // Group by term
  const terms = ['Term 1', 'Term 2', 'Final'];
  const gradesByTerm: Record<string, GradeRecord[]> = {};
  terms.forEach((t) => {
    gradesByTerm[t] = grades.filter((g) => g.term === t);
  });

  // Available terms (only those with data)
  const availableTerms = terms.filter((t) => gradesByTerm[t].length > 0);

  return (
    <GradesClientView
      studentList={children}
      selectedChildId={selectedChildId}
      selectedStudent={selectedStudent}
      gradesByTerm={gradesByTerm}
      availableTerms={availableTerms}
      allTerms={terms}
    />
  );
}
