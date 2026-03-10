"use client";

import { useState, useEffect, useCallback } from "react";
import { createClient } from "@/lib/supabase/client";
import { getInitials } from "@/lib/utils";
import {
  CalendarCheck,
  Check,
  X,
  Clock,
  ShieldCheck,
  Save,
  CheckCircle2,
  Loader2,
} from "lucide-react";
import type { Student, AttendanceRecord } from "@/types";

type AttendanceStatus = "present" | "absent" | "late" | "excused";

interface StudentAttendance {
  student: Student;
  status: AttendanceStatus;
  existingId?: string;
}

const GRADES = [
  "Pre-K",
  "K",
  "1",
  "2",
  "3",
  "4",
  "5",
  "6",
  "7",
  "8",
];
const SECTIONS = ["A", "B"];

const STATUS_CONFIG: Record<
  AttendanceStatus,
  { label: string; color: string; bgColor: string; icon: React.ElementType }
> = {
  present: {
    label: "Present",
    color: "#0A8F6C",
    bgColor: "#0A8F6C15",
    icon: Check,
  },
  absent: {
    label: "Absent",
    color: "#E8443A",
    bgColor: "#E8443A15",
    icon: X,
  },
  late: {
    label: "Late",
    color: "#F59E0B",
    bgColor: "#F59E0B15",
    icon: Clock,
  },
  excused: {
    label: "Excused",
    color: "#3B82F6",
    bgColor: "#3B82F615",
    icon: ShieldCheck,
  },
};

export default function AttendancePage() {
  const supabase = createClient();
  const [date, setDate] = useState(new Date().toISOString().split("T")[0]);
  const [grade, setGrade] = useState("");
  const [section, setSection] = useState("");
  const [students, setStudents] = useState<StudentAttendance[]>([]);
  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);
  const [saved, setSaved] = useState(false);
  const [error, setError] = useState("");

  const fetchStudents = useCallback(async () => {
    if (!grade || !section) {
      setStudents([]);
      return;
    }

    setLoading(true);
    setError("");
    setSaved(false);

    try {
      // Fetch students for the selected grade/section
      const { data: studentData, error: studentError } = await supabase
        .from("students")
        .select("*")
        .eq("grade", grade)
        .eq("section", section)
        .eq("is_active", true)
        .order("full_name");

      if (studentError) throw studentError;

      if (!studentData || studentData.length === 0) {
        setStudents([]);
        setLoading(false);
        return;
      }

      // Fetch existing attendance for this date
      const studentIds = studentData.map((s) => s.id);
      const { data: attendanceData } = await supabase
        .from("attendance_records")
        .select("*")
        .eq("date", date)
        .in("student_id", studentIds);

      const attendanceMap = new Map<string, AttendanceRecord>();
      attendanceData?.forEach((a) => attendanceMap.set(a.student_id, a));

      const mapped: StudentAttendance[] = studentData.map((s) => {
        const existing = attendanceMap.get(s.id);
        return {
          student: s,
          status: (existing?.status as AttendanceStatus) ?? "present",
          existingId: existing?.id,
        };
      });

      setStudents(mapped);
    } catch (err) {
      console.error(err);
      setError("Failed to load students. Please try again.");
    } finally {
      setLoading(false);
    }
  }, [grade, section, date, supabase]);

  useEffect(() => {
    fetchStudents();
  }, [fetchStudents]);

  function updateStatus(index: number, status: AttendanceStatus) {
    setStudents((prev) =>
      prev.map((s, i) => (i === index ? { ...s, status } : s))
    );
    setSaved(false);
  }

  async function handleSave() {
    if (students.length === 0) return;

    setSaving(true);
    setError("");

    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();

      const records = students.map((s) => ({
        ...(s.existingId ? { id: s.existingId } : {}),
        student_id: s.student.id,
        date,
        status: s.status,
        marked_by: user?.id ?? null,
      }));

      const { error: upsertError } = await supabase
        .from("attendance_records")
        .upsert(records, { onConflict: "student_id,date" });

      if (upsertError) throw upsertError;

      setSaved(true);
      // Refresh to get IDs
      await fetchStudents();
    } catch (err) {
      console.error(err);
      setError("Failed to save attendance. Please try again.");
    } finally {
      setSaving(false);
    }
  }

  const presentCount = students.filter((s) => s.status === "present").length;
  const totalCount = students.length;

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div>
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
          Mark Attendance
        </h1>
        <p className="text-sm text-[#5a6577] mt-1">
          Select a class and mark attendance for your students
        </p>
      </div>

      {/* Filters */}
      <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-5">
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          {/* Date Picker */}
          <div className="space-y-1.5">
            <label
              htmlFor="att-date"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Date
            </label>
            <input
              id="att-date"
              type="date"
              value={date}
              onChange={(e) => setDate(e.target.value)}
              className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            />
          </div>

          {/* Grade Dropdown */}
          <div className="space-y-1.5">
            <label
              htmlFor="att-grade"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Grade
            </label>
            <select
              id="att-grade"
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

          {/* Section Dropdown */}
          <div className="space-y-1.5">
            <label
              htmlFor="att-section"
              className="text-sm font-medium text-[#1a1a2e]"
            >
              Section
            </label>
            <select
              id="att-section"
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
        </div>
      </div>

      {/* Error */}
      {error && (
        <div className="bg-[#E8443A]/10 border border-[#E8443A]/20 rounded-xl p-4 text-sm text-[#E8443A]">
          {error}
        </div>
      )}

      {/* Success Toast */}
      {saved && (
        <div className="bg-[#0A8F6C]/10 border border-[#0A8F6C]/20 rounded-xl p-4 flex items-center gap-3">
          <CheckCircle2 className="w-5 h-5 text-[#0A8F6C] shrink-0" />
          <p className="text-sm text-[#0A8F6C] font-medium">
            Attendance saved successfully!
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

      {/* Empty state */}
      {!loading && grade && section && students.length === 0 && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <CalendarCheck className="w-12 h-12 text-[#5a6577]/40 mb-3" />
          <p className="text-sm text-[#5a6577]">
            No students found for {grade === "Pre-K" || grade === "K" ? grade : `Grade ${grade}`} Section {section}
          </p>
        </div>
      )}

      {/* No selection */}
      {!loading && (!grade || !section) && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <CalendarCheck className="w-12 h-12 text-[#5a6577]/40 mb-3" />
          <p className="text-sm text-[#5a6577]">
            Select a grade and section to start marking attendance
          </p>
        </div>
      )}

      {/* Student List */}
      {!loading && students.length > 0 && (
        <>
          {/* Count Display */}
          <div className="flex items-center justify-between">
            <p className="text-sm font-medium text-[#1a1a2e]">
              <span className="text-[#0A8F6C] font-bold">{presentCount}</span>{" "}
              of{" "}
              <span className="font-bold">{totalCount}</span> marked present
            </p>
            <div className="flex items-center gap-3 text-xs text-[#5a6577]">
              {(Object.entries(STATUS_CONFIG) as [AttendanceStatus, typeof STATUS_CONFIG["present"]][]).map(
                ([key, cfg]) => {
                  const count = students.filter((s) => s.status === key).length;
                  return (
                    <span key={key} className="flex items-center gap-1">
                      <span
                        className="w-2.5 h-2.5 rounded-full"
                        style={{ backgroundColor: cfg.color }}
                      />
                      {count} {cfg.label}
                    </span>
                  );
                }
              )}
            </div>
          </div>

          {/* Students */}
          <div className="space-y-2">
            {students.map((sa, index) => {
              const currentCfg = STATUS_CONFIG[sa.status];
              return (
                <div
                  key={sa.student.id}
                  className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 flex items-center gap-4 hover:shadow-sm transition-shadow"
                >
                  {/* Avatar */}
                  <div
                    className="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-sm font-semibold text-white"
                    style={{ backgroundColor: currentCfg.color }}
                  >
                    {getInitials(sa.student.full_name)}
                  </div>

                  {/* Name */}
                  <div className="flex-1 min-w-0">
                    <p className="text-sm font-semibold text-[#1a1a2e] truncate">
                      {sa.student.full_name}
                    </p>
                    <p className="text-xs text-[#5a6577]">
                      {sa.student.grade} - {sa.student.section}
                    </p>
                  </div>

                  {/* Status Buttons */}
                  <div className="flex items-center gap-1.5">
                    {(
                      Object.entries(STATUS_CONFIG) as [
                        AttendanceStatus,
                        typeof STATUS_CONFIG["present"]
                      ][]
                    ).map(([key, cfg]) => {
                      const Icon = cfg.icon;
                      const isSelected = sa.status === key;
                      return (
                        <button
                          key={key}
                          onClick={() => updateStatus(index, key)}
                          title={cfg.label}
                          className={`w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200 cursor-pointer ${
                            isSelected
                              ? "ring-2 shadow-sm"
                              : "hover:opacity-80"
                          }`}
                          style={{
                            backgroundColor: isSelected
                              ? cfg.bgColor
                              : "#F5F7FB",
                            color: isSelected ? cfg.color : "#5a6577",
                            borderColor: isSelected ? cfg.color : undefined,
                          }}
                        >
                          <Icon className="w-4 h-4" />
                        </button>
                      );
                    })}
                  </div>
                </div>
              );
            })}
          </div>

          {/* Save Button */}
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
              {saving ? "Saving..." : "Save Attendance"}
            </button>
          </div>
        </>
      )}
    </div>
  );
}
