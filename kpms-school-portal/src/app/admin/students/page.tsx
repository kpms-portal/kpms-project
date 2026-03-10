"use client";

import { useEffect, useState, useCallback } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { LoadingState } from "@/components/ui/loading-state";
import { EmptyState } from "@/components/ui/empty-state";
import { createClient } from "@/lib/supabase/client";
import { getInitials, formatDate } from "@/lib/utils";
import {
  Plus,
  Search,
  X,
  GraduationCap,
  ChevronDown,
  ToggleLeft,
  ToggleRight,
} from "lucide-react";
import type { Student, Profile } from "@/types";

type StudentWithParent = Student & { parent?: Pick<Profile, "full_name"> | null };

const gradeOptions = ["KG", "1", "2", "3", "4", "5", "6", "7", "8"];
const sectionOptions = ["A", "B", "C"];
const bloodGroupOptions = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];

export default function StudentsPage() {
  const [students, setStudents] = useState<StudentWithParent[]>([]);
  const [parents, setParents] = useState<Profile[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [gradeFilter, setGradeFilter] = useState("all");
  const [showForm, setShowForm] = useState(false);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [toggling, setToggling] = useState<string | null>(null);
  const [formData, setFormData] = useState({
    full_name: "",
    grade: "1",
    section: "A",
    date_of_birth: "",
    parent_id: "",
    blood_group: "",
  });

  const fetchStudents = useCallback(async () => {
    const supabase = createClient();

    const { data: studentsData, error: studentsError } = await supabase
      .from("students")
      .select("*, parent:profiles!students_parent_id_fkey(full_name)")
      .order("full_name", { ascending: true });

    if (studentsError) {
      console.error("Error fetching students:", studentsError);
      // Fallback: fetch without join
      const { data: fallbackData } = await supabase
        .from("students")
        .select("*")
        .order("full_name", { ascending: true });
      setStudents((fallbackData || []) as StudentWithParent[]);
    } else {
      setStudents((studentsData || []) as StudentWithParent[]);
    }
    setLoading(false);
  }, []);

  const fetchParents = useCallback(async () => {
    const supabase = createClient();
    const { data } = await supabase
      .from("profiles")
      .select("id, full_name, email, role")
      .eq("role", "parent")
      .order("full_name", { ascending: true });
    setParents((data || []) as Profile[]);
  }, []);

  useEffect(() => {
    fetchStudents();
    fetchParents();
  }, [fetchStudents, fetchParents]);

  const filtered = students.filter((s) => {
    const matchesSearch =
      search === "" || s.full_name.toLowerCase().includes(search.toLowerCase());
    const matchesGrade = gradeFilter === "all" || s.grade === gradeFilter;
    return matchesSearch && matchesGrade;
  });

  const uniqueGrades = Array.from(new Set(students.map((s) => s.grade))).sort();

  async function handleAddStudent(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    setError(null);

    try {
      const supabase = createClient();
      const { error: insertError } = await supabase.from("students").insert({
        full_name: formData.full_name,
        grade: formData.grade,
        section: formData.section,
        date_of_birth: formData.date_of_birth || null,
        parent_id: formData.parent_id || null,
        blood_group: formData.blood_group || null,
        is_active: true,
        enrollment_date: new Date().toISOString().split("T")[0],
      });

      if (insertError) throw insertError;

      setShowForm(false);
      setFormData({
        full_name: "",
        grade: "1",
        section: "A",
        date_of_birth: "",
        parent_id: "",
        blood_group: "",
      });
      await fetchStudents();
    } catch (err) {
      setError(err instanceof Error ? err.message : "Failed to add student");
    } finally {
      setSaving(false);
    }
  }

  async function toggleActive(studentId: string, currentStatus: boolean) {
    setToggling(studentId);
    const supabase = createClient();
    const { error: updateError } = await supabase
      .from("students")
      .update({ is_active: !currentStatus })
      .eq("id", studentId);

    if (!updateError) {
      setStudents((prev) =>
        prev.map((s) =>
          s.id === studentId ? { ...s, is_active: !currentStatus } : s
        )
      );
    }
    setToggling(null);
  }

  if (loading) {
    return <LoadingState message="Loading students..." />;
  }

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h1 className="font-heading text-2xl font-bold text-foreground">
            Student Management
          </h1>
          <p className="text-sm text-muted-foreground mt-1">
            {students.length} total student{students.length !== 1 ? "s" : ""}
          </p>
        </div>
        <Button className="gap-2" onClick={() => setShowForm(true)}>
          <Plus className="w-4 h-4" />
          Add Student
        </Button>
      </div>

      {/* Add Student Form */}
      {showForm && (
        <Card>
          <CardContent className="p-6">
            <div className="flex items-center justify-between mb-4">
              <h2 className="font-heading text-lg font-semibold">Add New Student</h2>
              <button
                onClick={() => {
                  setShowForm(false);
                  setError(null);
                }}
                className="p-1 rounded-lg hover:bg-muted transition-colors"
              >
                <X className="w-5 h-5 text-muted-foreground" />
              </button>
            </div>

            {error && (
              <div className="mb-4 px-4 py-3 rounded-xl bg-red-50 text-[#E8443A] text-sm border border-red-200">
                {error}
              </div>
            )}

            <form onSubmit={handleAddStudent} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div className="space-y-2">
                <Label htmlFor="student_name">Full Name</Label>
                <Input
                  id="student_name"
                  value={formData.full_name}
                  onChange={(e) => setFormData({ ...formData, full_name: e.target.value })}
                  placeholder="e.g. Ali Khan"
                  required
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="student_grade">Grade</Label>
                <div className="relative">
                  <select
                    id="student_grade"
                    value={formData.grade}
                    onChange={(e) => setFormData({ ...formData, grade: e.target.value })}
                    className="w-full h-8 rounded-lg border border-input bg-transparent px-2.5 text-sm outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 appearance-none pr-8"
                  >
                    {gradeOptions.map((g) => (
                      <option key={g} value={g}>
                        {g === "KG" ? "Kindergarten" : `Grade ${g}`}
                      </option>
                    ))}
                  </select>
                  <ChevronDown className="absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                </div>
              </div>
              <div className="space-y-2">
                <Label htmlFor="student_section">Section</Label>
                <div className="relative">
                  <select
                    id="student_section"
                    value={formData.section}
                    onChange={(e) => setFormData({ ...formData, section: e.target.value })}
                    className="w-full h-8 rounded-lg border border-input bg-transparent px-2.5 text-sm outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 appearance-none pr-8"
                  >
                    {sectionOptions.map((s) => (
                      <option key={s} value={s}>
                        Section {s}
                      </option>
                    ))}
                  </select>
                  <ChevronDown className="absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                </div>
              </div>
              <div className="space-y-2">
                <Label htmlFor="student_dob">Date of Birth</Label>
                <Input
                  id="student_dob"
                  type="date"
                  value={formData.date_of_birth}
                  onChange={(e) => setFormData({ ...formData, date_of_birth: e.target.value })}
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="student_parent">Parent</Label>
                <div className="relative">
                  <select
                    id="student_parent"
                    value={formData.parent_id}
                    onChange={(e) => setFormData({ ...formData, parent_id: e.target.value })}
                    className="w-full h-8 rounded-lg border border-input bg-transparent px-2.5 text-sm outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 appearance-none pr-8"
                  >
                    <option value="">No parent assigned</option>
                    {parents.map((p) => (
                      <option key={p.id} value={p.id}>
                        {p.full_name}
                      </option>
                    ))}
                  </select>
                  <ChevronDown className="absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                </div>
              </div>
              <div className="space-y-2">
                <Label htmlFor="student_blood">Blood Group</Label>
                <div className="relative">
                  <select
                    id="student_blood"
                    value={formData.blood_group}
                    onChange={(e) => setFormData({ ...formData, blood_group: e.target.value })}
                    className="w-full h-8 rounded-lg border border-input bg-transparent px-2.5 text-sm outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 appearance-none pr-8"
                  >
                    <option value="">Select</option>
                    {bloodGroupOptions.map((bg) => (
                      <option key={bg} value={bg}>
                        {bg}
                      </option>
                    ))}
                  </select>
                  <ChevronDown className="absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                </div>
              </div>
              <div className="md:col-span-2 lg:col-span-3 flex justify-end gap-3 pt-2">
                <Button
                  type="button"
                  variant="outline"
                  onClick={() => {
                    setShowForm(false);
                    setError(null);
                  }}
                >
                  Cancel
                </Button>
                <Button type="submit" disabled={saving}>
                  {saving ? "Adding..." : "Add Student"}
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      )}

      {/* Search and Filter */}
      <div className="flex flex-col sm:flex-row gap-3">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
          <Input
            placeholder="Search students by name..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="pl-10"
          />
        </div>
        <div className="relative">
          <select
            value={gradeFilter}
            onChange={(e) => setGradeFilter(e.target.value)}
            className="h-8 rounded-lg border border-input bg-transparent px-2.5 text-sm outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 appearance-none pr-8 min-w-[140px]"
          >
            <option value="all">All Grades</option>
            {uniqueGrades.map((g) => (
              <option key={g} value={g}>
                {g === "KG" ? "Kindergarten" : `Grade ${g}`}
              </option>
            ))}
          </select>
          <ChevronDown className="absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
        </div>
      </div>

      {/* Students Table */}
      {filtered.length === 0 ? (
        <EmptyState icon={GraduationCap} message="No students match your filters." />
      ) : (
        <Card>
          <CardContent className="p-0">
            {/* Table Header */}
            <div className="hidden lg:grid grid-cols-[2fr_1fr_1fr_1.5fr_1fr_1fr_80px] gap-4 px-4 py-3 bg-[#F5F7FB] border-b border-[#e2e8f0] text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
              <span>Name</span>
              <span>Grade</span>
              <span>Section</span>
              <span>Parent</span>
              <span>Enrolled</span>
              <span>Status</span>
              <span>Toggle</span>
            </div>

            <div className="divide-y divide-[#e2e8f0]">
              {filtered.map((student) => {
                const parentName =
                  student.parent?.full_name || "Unassigned";

                return (
                  <div
                    key={student.id}
                    className="flex flex-col lg:grid lg:grid-cols-[2fr_1fr_1fr_1.5fr_1fr_1fr_80px] gap-2 lg:gap-4 items-start lg:items-center px-4 py-3 hover:bg-muted/50 transition-colors"
                  >
                    <div className="flex items-center gap-3">
                      <Avatar className="h-9 w-9 shrink-0">
                        <AvatarFallback className="bg-[#003087] text-white text-xs font-medium">
                          {getInitials(student.full_name)}
                        </AvatarFallback>
                      </Avatar>
                      <span className="font-medium text-foreground text-sm">
                        {student.full_name}
                      </span>
                    </div>
                    <span className="text-sm text-muted-foreground">
                      {student.grade === "KG" ? "KG" : `Grade ${student.grade}`}
                    </span>
                    <span className="text-sm text-muted-foreground">
                      {student.section}
                    </span>
                    <span className="text-sm text-muted-foreground truncate max-w-full">
                      {parentName}
                    </span>
                    <span className="text-xs text-muted-foreground">
                      {formatDate(student.enrollment_date)}
                    </span>
                    <Badge
                      variant="secondary"
                      className={
                        student.is_active
                          ? "bg-[#0A8F6C]/10 text-[#0A8F6C]"
                          : "bg-[#E8443A]/10 text-[#E8443A]"
                      }
                    >
                      {student.is_active ? "Active" : "Inactive"}
                    </Badge>
                    <button
                      onClick={() => toggleActive(student.id, student.is_active)}
                      disabled={toggling === student.id}
                      className="p-1 rounded-lg hover:bg-muted transition-colors disabled:opacity-50"
                      title={student.is_active ? "Deactivate" : "Activate"}
                    >
                      {student.is_active ? (
                        <ToggleRight className="w-6 h-6 text-[#0A8F6C]" />
                      ) : (
                        <ToggleLeft className="w-6 h-6 text-[#5a6577]" />
                      )}
                    </button>
                  </div>
                );
              })}
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  );
}
