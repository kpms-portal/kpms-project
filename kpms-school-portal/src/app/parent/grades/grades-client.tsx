'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Card, CardContent } from '@/components/ui/card';
import { EmptyState } from '@/components/ui/empty-state';
import { BookOpen, TrendingUp } from 'lucide-react';
import type { Student, GradeRecord } from '@/types';
import { getGradeColor } from '@/lib/utils';

interface GradesClientViewProps {
  studentList: Student[];
  selectedChildId: string;
  selectedStudent: Student;
  gradesByTerm: Record<string, GradeRecord[]>;
  availableTerms: string[];
  allTerms: string[];
}

export function GradesClientView({
  studentList,
  selectedChildId,
  selectedStudent,
  gradesByTerm,
  availableTerms,
  allTerms,
}: GradesClientViewProps) {
  const router = useRouter();
  const [activeTerm, setActiveTerm] = useState(
    availableTerms.length > 0 ? availableTerms[0] : allTerms[0]
  );

  const currentGrades = gradesByTerm[activeTerm] || [];

  // Calculate overall average for this term
  const gradesWithPercent = currentGrades.filter(
    (g) => g.grade_percent != null
  );
  const overallAvg =
    gradesWithPercent.length > 0
      ? Math.round(
          gradesWithPercent.reduce((sum, g) => sum + (g.grade_percent || 0), 0) /
            gradesWithPercent.length
        )
      : null;

  const handleChildChange = (childId: string) => {
    router.push(`/parent/grades?child=${childId}`);
  };

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            Grades
          </h1>
          <p className="text-sm text-[#5a6577] mt-1">
            {selectedStudent.full_name} - Grade {selectedStudent.grade}, Section{' '}
            {selectedStudent.section}
          </p>
        </div>

        {/* Child selector */}
        {studentList.length > 1 && (
          <select
            value={selectedChildId}
            onChange={(e) => handleChildChange(e.target.value)}
            className="h-10 rounded-xl border border-[#e2e8f0] bg-white px-4 text-sm font-medium text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/20 focus:border-[#003087]"
          >
            {studentList.map((child) => (
              <option key={child.id} value={child.id}>
                {child.full_name}
              </option>
            ))}
          </select>
        )}
      </div>

      {/* Term Tabs */}
      <div className="flex gap-2">
        {allTerms.map((term) => (
          <button
            key={term}
            onClick={() => setActiveTerm(term)}
            className={`px-5 py-2.5 rounded-xl text-sm font-medium transition-colors ${
              activeTerm === term
                ? 'bg-[#003087] text-white shadow-sm'
                : 'bg-white text-[#5a6577] hover:bg-[#F5F7FB] border border-[#e2e8f0]'
            }`}
          >
            {term}
          </button>
        ))}
      </div>

      {/* Grades Table */}
      {currentGrades.length === 0 ? (
        <EmptyState
          icon={BookOpen}
          message={`No grades recorded for ${activeTerm} yet.`}
        />
      ) : (
        <>
          <Card>
            <CardContent className="p-0">
              <div className="overflow-x-auto">
                <table className="w-full text-sm">
                  <thead>
                    <tr className="border-b border-[#e2e8f0] bg-[#F5F7FB]">
                      <th className="text-left p-4 font-medium text-[#5a6577]">
                        Subject
                      </th>
                      <th className="text-center p-4 font-medium text-[#5a6577]">
                        Grade
                      </th>
                      <th className="text-center p-4 font-medium text-[#5a6577]">
                        Percentage
                      </th>
                      <th className="text-left p-4 font-medium text-[#5a6577] hidden md:table-cell">
                        Teacher Comments
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {currentGrades.map((grade) => {
                      const percentColor = grade.grade_percent
                        ? getGradeColor(grade.grade_percent)
                        : '#5a6577';

                      return (
                        <tr
                          key={grade.id}
                          className="border-b border-[#e2e8f0] last:border-0 hover:bg-[#F5F7FB]/50 transition-colors"
                        >
                          <td className="p-4">
                            <div className="flex items-center gap-3">
                              <div
                                className="w-3 h-3 rounded-full shrink-0"
                                style={{ backgroundColor: percentColor }}
                              />
                              <span className="font-medium text-[#1a1a2e]">
                                {grade.subject}
                              </span>
                            </div>
                          </td>
                          <td className="p-4 text-center">
                            <span
                              className="font-bold text-lg"
                              style={{ color: percentColor }}
                            >
                              {grade.grade_letter || '--'}
                            </span>
                          </td>
                          <td className="p-4 text-center">
                            {grade.grade_percent != null ? (
                              <div className="flex items-center justify-center gap-2">
                                <div className="w-16 h-2 bg-gray-100 rounded-full overflow-hidden hidden sm:block">
                                  <div
                                    className="h-full rounded-full transition-all duration-500"
                                    style={{
                                      width: `${grade.grade_percent}%`,
                                      backgroundColor: percentColor,
                                    }}
                                  />
                                </div>
                                <span
                                  className="font-semibold text-sm"
                                  style={{ color: percentColor }}
                                >
                                  {grade.grade_percent}%
                                </span>
                              </div>
                            ) : (
                              <span className="text-[#5a6577]">--</span>
                            )}
                          </td>
                          <td className="p-4 text-[#5a6577] text-xs hidden md:table-cell max-w-xs">
                            {grade.teacher_comments || (
                              <span className="italic text-[#5a6577]/60">
                                No comments
                              </span>
                            )}
                          </td>
                        </tr>
                      );
                    })}
                  </tbody>
                </table>
              </div>
            </CardContent>
          </Card>

          {/* Overall Average */}
          {overallAvg !== null && (
            <Card className="border-[#003087]/20">
              <CardContent className="p-5">
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-3">
                    <div className="w-12 h-12 rounded-xl bg-[#003087]/10 flex items-center justify-center">
                      <TrendingUp className="w-6 h-6 text-[#003087]" />
                    </div>
                    <div>
                      <p className="text-sm font-medium text-[#5a6577]">
                        Overall Average - {activeTerm}
                      </p>
                      <p className="text-sm text-[#5a6577]/70">
                        Across {gradesWithPercent.length} subjects
                      </p>
                    </div>
                  </div>
                  <div className="text-right">
                    <p
                      className="text-3xl font-bold"
                      style={{ color: getGradeColor(overallAvg) }}
                    >
                      {overallAvg}%
                    </p>
                    <p
                      className="text-sm font-medium"
                      style={{ color: getGradeColor(overallAvg) }}
                    >
                      {overallAvg >= 90
                        ? 'Excellent'
                        : overallAvg >= 80
                        ? 'Very Good'
                        : overallAvg >= 70
                        ? 'Good'
                        : overallAvg >= 60
                        ? 'Satisfactory'
                        : 'Needs Improvement'}
                    </p>
                  </div>
                </div>
              </CardContent>
            </Card>
          )}

          {/* Mobile: Comments for subjects */}
          <div className="md:hidden space-y-2">
            {currentGrades
              .filter((g) => g.teacher_comments)
              .map((grade) => (
                <Card key={`comment-${grade.id}`}>
                  <CardContent className="p-3">
                    <p className="text-xs font-semibold text-[#1a1a2e] mb-1">
                      {grade.subject}
                    </p>
                    <p className="text-xs text-[#5a6577]">
                      {grade.teacher_comments}
                    </p>
                  </CardContent>
                </Card>
              ))}
          </div>
        </>
      )}
    </div>
  );
}
