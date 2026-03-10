"use client";

import { useState, useEffect, useCallback } from "react";
import { createClient } from "@/lib/supabase/client";
import { getInitials, getGradeColor } from "@/lib/utils";
import {
  Award,
  Save,
  CheckCircle2,
  Loader2,
  GraduationCap,
} from "lucide-react";
import type { Student } from "@/types";

const GRADES = ["Pre-K", "K", "1", "2", "3", "4", "5", "6", "7", "8"];
const SECTIONS = ["A", "B"];
const TERMS = ["Term 1", "Term 2", "Final"];
const SUBJECTS = [
  "Mathematics",
  "English",
  "Science",
  "Urdu",
  "Social Studies",
  "Islamiyat",
  "Art",
  "Physical Education",
];
const GRADE_LETTERS = ["A+", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D", "F"];

interface GradeEntry {
  student: Student;
  gradeLetter: string;
  percentage: number | "";
  comments: string;
  existingId?: string;
}

export default function GradesPage() {
  const supabase = createClient();
  const [grade, setGrade] = useState("");
  const [section, setSection] = useState("");
  const [term, setTerm] = useState("");
  const [subject, setSubject] = useState("");
  const [entries, setEntries] = useState<GradeEntry[]>([]);
  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);
  const [saved, setSaved] = useState(false);
  const [error, setError] = useState("");
  const [validationErrors, setValidationErrors] = useState<
    Map<string, string>
  >(new Map());

  const allSelected = grade && section && term && subject;

  const fetchStudentsAndGrades = useCallback(async () => {
    if (!grade || !section || !term || !subject) {
      setEntries([]);
      return;
    }

    setLoading(true);
    setError("");
    setSaved(false);

    try {
      // Fetch students
      const { data: studentData, error: studentError } = await supabase
        .from("students")
        .select("*")
        .eq("grade", grade)
        .eq("section", section)
        .eq("is_active", true)
        .order("full_name");

      if (studentError) throw studentError;

      if (!studentData || studentData.length === 0) {
        setEntries([]);
        setLoading(false);
        return;
      }

      // Fetch existing grades
      const studentIds = studentData.map((s) => s.id);
      const { data: gradeData } = await supabase
        .from("grade_records")
        .select("*")
        .eq("term", term)
        .eq("subject", subject)
        .in("student_id", studentIds);

      const gradeMap = new Map<
        string,
        {
          id: string;
          grade_letter: string | null;
          grade_percent: number | null;
          teacher_comments: string | null;
        }
      >();
      gradeData?.forEach((g) => gradeMap.set(g.student_id, g));

      const mapped: GradeEntry[] = studentData.map((s) => {
        const existing = gradeMap.get(s.id);
        return {
          student: s,
          gradeLetter: existing?.grade_letter ?? "",
          percentage: existing?.grade_percent ?? "",
          comments: existing?.teacher_comments ?? "",
          existingId: existing?.id,
        };
      });

      setEntries(mapped);
    } catch (err) {
      console.error(err);
      setError("Failed to load students. Please try again.");
    } finally {
      setLoading(false);
    }
  }, [grade, section, term, subject, supabase]);

  useEffect(() => {
    fetchStudentsAndGrades();
  }, [fetchStudentsAndGrades]);

  function updateEntry(
    index: number,
    field: "gradeLetter" | "percentage" | "comments",
    value: string | number
  ) {
    setEntries((prev) =>
      prev.map((e, i) => (i === index ? { ...e, [field]: value } : e))
    );
    setSaved(false);

    // Clear validation error for this field
    const key = `${index}-${field}`;
    if (validationErrors.has(key)) {
      setValidationErrors((prev) => {
        const next = new Map(prev);
        next.delete(key);
        return next;
      });
    }
  }

  function validate(): boolean {
    const errors = new Map<string, string>();

    entries.forEach((entry, index) => {
      if (entry.percentage !== "" && entry.percentage !== null) {
        const pct =
          typeof entry.percentage === "string"
            ? parseFloat(entry.percentage)
            : entry.percentage;
        if (isNaN(pct) || pct < 0 || pct > 100) {
          errors.set(
            `${index}-percentage`,
            "Must be 0-100"
          );
        }
      }
    });

    setValidationErrors(errors);
    return errors.size === 0;
  }

  async function handleSave() {
    if (entries.length === 0 || !validate()) return;

    setSaving(true);
    setError("");

    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();

      const records = entries
        .filter((e) => e.gradeLetter || e.percentage !== "")
        .map((e) => ({
          ...(e.existingId ? { id: e.existingId } : {}),
          student_id: e.student.id,
          term,
          subject,
          grade_letter: e.gradeLetter || null,
          grade_percent:
            e.percentage !== ""
              ? typeof e.percentage === "string"
                ? parseFloat(e.percentage)
                : e.percentage
              : null,
          teacher_comments: e.comments || null,
          entered_by: user?.id ?? null,
        }));

      if (records.length === 0) {
        setError("Please enter at least one grade before saving.");
        setSaving(false);
        return;
      }

      const { error: upsertError } = await supabase
        .from("grade_records")
        .upsert(records, { onConflict: "student_id,term,subject" });

      if (upsertError) throw upsertError;

      setSaved(true);
      await fetchStudentsAndGrades();
    } catch (err) {
      console.error(err);
      setError("Failed to save grades. Please try again.");
    } finally {
      setSaving(false);
    }
  }

  return (
    <div className="space-y-6 max-w-5xl">
      {/* Header */}
      <div>
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
          Enter Grades
        </h1>
        <p className="text-sm text-[#5a6577] mt-1">
          Select a class, term, and subject to enter student grades
        </p>
      </div>

      {/* Filters */}
      <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {/* Grade */}
          <div className="space-y-1.5">
            <label
              htmlFor="gr-grade"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Grade
            </label>
            <select
              id="gr-grade"
              value={grade}
              onChange={(e) => setGrade(e.target.value)}
              className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            >
              <option value="">Select Grade</option>
              {GRADES.map((g) => (
                <option key={g} value={g}>
                  {g === "Pre-K" || g === "K" ? g : `Grade ${g}`}
                </option>
              ))}
            </select>
          </div>

          {/* Section */}
          <div className="space-y-1.5">
            <label
              htmlFor="gr-section"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Section
            </label>
            <select
              id="gr-section"
              value={section}
              onChange={(e) => setSection(e.target.value)}
              className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            >
              <option value="">Select Section</option>
              {SECTIONS.map((s) => (
                <option key={s} value={s}>
                  Section {s}
                </option>
              ))}
            </select>
          </div>

          {/* Term */}
          <div className="space-y-1.5">
            <label
              htmlFor="gr-term"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Term
            </label>
            <select
              id="gr-term"
              value={term}
              onChange={(e) => setTerm(e.target.value)}
              className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            >
              <option value="">Select Term</option>
              {TERMS.map((t) => (
                <option key={t} value={t}>
                  {t}
                </option>
              ))}
            </select>
          </div>

          {/* Subject */}
          <div className="space-y-1.5">
            <label
              htmlFor="gr-subject"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Subject
            </label>
            <select
              id="gr-subject"
              value={subject}
              onChange={(e) => setSubject(e.target.value)}
              className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            >
              <option value="">Select Subject</option>
              {SUBJECTS.map((s) => (
                <option key={s} value={s}>
                  {s}
                </option>
              ))}
            </select>
          </div>
        </div>
      </div>

      {/* Error */}
      {error && (
        <div className="bg-[#E8443A]/10 border border-[#E8443A]/20 rounded-xl p-4 text-sm text-[#E8443A]">
          {error}
        </div>
      )}

      {/* Success */}
      {saved && (
        <div className="bg-[#0A8F6C]/10 border border-[#0A8F6C]/20 rounded-xl p-4 flex items-center gap-3">
          <CheckCircle2 className="w-5 h-5 text-[#0A8F6C] shrink-0" />
          <p className="text-sm text-[#0A8F6C] font-medium">
            Grades saved successfully!
          </p>
        </div>
      )}

      {/* Loading */}
      {loading && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <Loader2 className="w-8 h-8 text-[#003087] animate-spin mb-3" />
          <p className="text-sm text-[#5a6577]">Loading students...</p>
        </div>
      )}

      {/* No selection */}
      {!loading && !allSelected && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <GraduationCap className="w-12 h-12 text-[#5a6577]/40 mb-3" />
          <p className="text-sm text-[#5a6577]">
            Select grade, section, term, and subject to begin
          </p>
        </div>
      )}

      {/* Empty */}
      {!loading && allSelected && entries.length === 0 && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <Award className="w-12 h-12 text-[#5a6577]/40 mb-3" />
          <p className="text-sm text-[#5a6577]">
            No students found for this class
          </p>
        </div>
      )}

      {/* Grade Table */}
      {!loading && entries.length > 0 && (
        <>
          <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] overflow-hidden">
            {/* Table Header */}
            <div className="hidden md:grid md:grid-cols-[1fr_120px_120px_1fr] gap-4 px-5 py-3 bg-[#F5F7FB] border-b border-[#e2e8f0] text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
              <span>Student</span>
              <span>Grade</span>
              <span>Percentage</span>
              <span>Comments</span>
            </div>

            {/* Rows */}
            <div className="divide-y divide-[#e2e8f0]">
              {entries.map((entry, index) => {
                const pctNum =
                  entry.percentage !== ""
                    ? typeof entry.percentage === "string"
                      ? parseFloat(entry.percentage)
                      : entry.percentage
                    : null;
                const pctColor = pctNum !== null ? getGradeColor(pctNum) : "#5a6577";
                const pctError = validationErrors.get(
                  `${index}-percentage`
                );

                return (
                  <div
                    key={entry.student.id}
                    className="p-4 md:p-5 md:grid md:grid-cols-[1fr_120px_120px_1fr] gap-4 items-center space-y-3 md:space-y-0"
                  >
                    {/* Student */}
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-[#003087] flex items-center justify-center text-white text-xs font-semibold shrink-0">
                        {getInitials(entry.student.full_name)}
                      </div>
                      <div className="min-w-0">
                        <p className="text-sm font-semibold text-[#1a1a2e] truncate">
                          {entry.student.full_name}
                        </p>
                      </div>
                    </div>

                    {/* Grade Letter */}
                    <div>
                      <label className="md:hidden text-xs font-medium text-[#5a6577] mb-1 block">
                        Grade
                      </label>
                      <select
                        value={entry.gradeLetter}
                        onChange={(e) =>
                          updateEntry(index, "gradeLetter", e.target.value)
                        }
                        className="w-full h-9 rounded-lg border border-[#e2e8f0] bg-white px-2 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30"
                      >
                        <option value="">--</option>
                        {GRADE_LETTERS.map((gl) => (
                          <option key={gl} value={gl}>
                            {gl}
                          </option>
                        ))}
                      </select>
                    </div>

                    {/* Percentage */}
                    <div>
                      <label className="md:hidden text-xs font-medium text-[#5a6577] mb-1 block">
                        Percentage
                      </label>
                      <div className="relative">
                        <input
                          type="number"
                          min={0}
                          max={100}
                          value={entry.percentage}
                          onChange={(e) => {
                            const val = e.target.value;
                            updateEntry(
                              index,
                              "percentage",
                              val === "" ? "" : val
                            );
                          }}
                          placeholder="0-100"
                          className={`w-full h-9 rounded-lg border px-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 ${
                            pctError
                              ? "border-[#E8443A] bg-[#E8443A]/5"
                              : "border-[#e2e8f0] bg-white"
                          }`}
                          style={
                            pctNum !== null && !pctError
                              ? { color: pctColor }
                              : {}
                          }
                        />
                        {pctError && (
                          <p className="text-[10px] text-[#E8443A] mt-0.5 absolute">
                            {pctError}
                          </p>
                        )}
                      </div>
                    </div>

                    {/* Comments */}
                    <div>
                      <label className="md:hidden text-xs font-medium text-[#5a6577] mb-1 block">
                        Comments
                      </label>
                      <input
                        type="text"
                        value={entry.comments}
                        onChange={(e) =>
                          updateEntry(index, "comments", e.target.value)
                        }
                        placeholder="Optional comments..."
                        className="w-full h-9 rounded-lg border border-[#e2e8f0] bg-white px-2 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30"
                      />
                    </div>
                  </div>
                );
              })}
            </div>
          </div>

          {/* Save */}
          <div className="flex justify-end">
            <button
              onClick={handleSave}
              disabled={saving}
              className="inline-flex items-center gap-2 h-11 px-6 rounded-xl bg-[#003087] text-white text-sm font-semibold hover:bg-[#003087]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
            >
              {saving ? (
                <Loader2 className="w-4 h-4 animate-spin" />
              ) : (
                <Save className="w-4 h-4" />
              )}
              {saving ? "Saving..." : "Save All Grades"}
            </button>
          </div>
        </>
      )}
    </div>
  );
}
