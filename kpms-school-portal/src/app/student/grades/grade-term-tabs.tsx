"use client";

import { useState } from "react";
import { getGradeColor } from "@/lib/utils";
import type { GradeRecord } from "@/types";
import { BookOpen } from "lucide-react";

interface GradeTermTabsProps {
  terms: string[];
  grades: GradeRecord[];
}

export function GradeTermTabs({ terms, grades }: GradeTermTabsProps) {
  const [activeTerm, setActiveTerm] = useState(terms[0] || "Term 1");

  const filteredGrades = grades.filter((g) => g.term === activeTerm);

  return (
    <div>
      {/* Term Tabs */}
      <div className="flex gap-1 bg-white rounded-xl p-1 ring-1 ring-[#e2e8f0] w-fit mb-6">
        {terms.map((term) => (
          <button
            key={term}
            onClick={() => setActiveTerm(term)}
            className={`px-5 py-2 rounded-lg text-sm font-medium transition-all ${
              activeTerm === term
                ? "bg-[#003087] text-white shadow-sm"
                : "text-[#5a6577] hover:text-[#1a1a2e] hover:bg-[#F5F7FB]"
            }`}
          >
            {term}
          </button>
        ))}
      </div>

      {/* Grades Table */}
      <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] overflow-hidden">
        {filteredGrades.length > 0 ? (
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-[#e2e8f0] bg-[#F5F7FB]">
                  <th className="text-left px-5 py-3 text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
                    Subject
                  </th>
                  <th className="text-left px-5 py-3 text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
                    Grade
                  </th>
                  <th className="text-left px-5 py-3 text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
                    Percentage
                  </th>
                  <th className="text-left px-5 py-3 text-xs font-semibold text-[#5a6577] uppercase tracking-wider hidden sm:table-cell">
                    Comments
                  </th>
                </tr>
              </thead>
              <tbody className="divide-y divide-[#e2e8f0]">
                {filteredGrades.map((grade) => (
                  <tr
                    key={grade.id}
                    className="hover:bg-[#F5F7FB] transition-colors"
                  >
                    <td className="px-5 py-4">
                      <span className="text-sm font-medium text-[#1a1a2e]">
                        {grade.subject}
                      </span>
                    </td>
                    <td className="px-5 py-4">
                      <span className="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-[#F5F7FB] text-sm font-bold text-[#1a1a2e]">
                        {grade.grade_letter || "--"}
                      </span>
                    </td>
                    <td className="px-5 py-4">
                      {grade.grade_percent !== null ? (
                        <div className="flex items-center gap-3">
                          <div className="w-24 h-2 bg-[#e2e8f0] rounded-full overflow-hidden">
                            <div
                              className="h-full rounded-full transition-all"
                              style={{
                                width: `${grade.grade_percent}%`,
                                backgroundColor: getGradeColor(
                                  grade.grade_percent
                                ),
                              }}
                            />
                          </div>
                          <span
                            className="text-sm font-semibold"
                            style={{
                              color: getGradeColor(grade.grade_percent),
                            }}
                          >
                            {grade.grade_percent}%
                          </span>
                        </div>
                      ) : (
                        <span className="text-sm text-[#5a6577]">--</span>
                      )}
                    </td>
                    <td className="px-5 py-4 hidden sm:table-cell">
                      <span className="text-sm text-[#5a6577]">
                        {grade.teacher_comments || "--"}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : (
          <div className="p-12 text-center">
            <BookOpen className="w-10 h-10 text-[#e2e8f0] mx-auto mb-3" />
            <p className="text-sm text-[#5a6577]">
              No grades available for {activeTerm}
            </p>
          </div>
        )}
      </div>

      {/* Summary Card */}
      {filteredGrades.length > 0 && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5 mt-4">
          <h3 className="font-heading text-sm font-semibold text-[#1a1a2e] mb-3">
            {activeTerm} Summary
          </h3>
          <div className="grid grid-cols-3 gap-4">
            <div>
              <p className="text-xs text-[#5a6577]">Average</p>
              <p className="text-lg font-bold text-[#1a1a2e]">
                {Math.round(
                  filteredGrades.reduce(
                    (sum, g) => sum + (g.grade_percent || 0),
                    0
                  ) / filteredGrades.length
                )}
                %
              </p>
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">Highest</p>
              <p className="text-lg font-bold text-[#0A8F6C]">
                {Math.max(
                  ...filteredGrades.map((g) => g.grade_percent || 0)
                )}
                %
              </p>
            </div>
            <div>
              <p className="text-xs text-[#5a6577]">Subjects</p>
              <p className="text-lg font-bold text-[#1a1a2e]">
                {filteredGrades.length}
              </p>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
