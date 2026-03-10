import { createServerSupabase } from "@/lib/supabase/server";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { EmptyState } from "@/components/ui/empty-state";
import { School, Users } from "lucide-react";

interface ClassRow {
  id: string;
  name: string;
  grade_level: string;
  section: string;
  capacity: number | null;
  teacher_id: string | null;
  teacher?: { full_name: string } | null;
}

export default async function ClassesPage() {
  const supabase = await createServerSupabase();

  const { data: classes } = await supabase
    .from("classes")
    .select("id, name, grade_level, section, capacity, teacher_id, teacher:profiles!classes_teacher_id_fkey(full_name)")
    .order("grade_level", { ascending: true });

  const classRows = (classes || []) as ClassRow[];

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-[#003087]/10 flex items-center justify-center">
            <School className="w-5 h-5 text-[#003087]" />
          </div>
          <div>
            <h1 className="font-heading text-2xl font-bold text-foreground">Classes</h1>
            <p className="text-sm text-muted-foreground mt-0.5">
              {classRows.length} class{classRows.length !== 1 ? "es" : ""} registered
            </p>
          </div>
        </div>
      </div>

      {/* Classes List */}
      {classRows.length === 0 ? (
        <Card>
          <CardContent className="p-0">
            <EmptyState
              icon={School}
              title="No classes yet"
              description="No classes have been created. Add classes to get started."
            />
          </CardContent>
        </Card>
      ) : (
        <Card>
          <CardContent className="p-0">
            {/* Table Header */}
            <div className="hidden lg:grid grid-cols-[2fr_1fr_1fr_1fr_1.5fr] gap-4 px-4 py-3 bg-[#F5F7FB] border-b border-[#e2e8f0] text-xs font-semibold text-[#5a6577] uppercase tracking-wider">
              <span>Class Name</span>
              <span>Grade</span>
              <span>Section</span>
              <span>Capacity</span>
              <span>Teacher</span>
            </div>

            <div className="divide-y divide-[#e2e8f0]">
              {classRows.map((cls) => (
                <div
                  key={cls.id}
                  className="flex flex-col lg:grid lg:grid-cols-[2fr_1fr_1fr_1fr_1.5fr] gap-2 lg:gap-4 items-start lg:items-center px-4 py-3 hover:bg-muted/50 transition-colors"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-9 h-9 rounded-lg bg-[#003087]/10 flex items-center justify-center shrink-0">
                      <School className="w-4 h-4 text-[#003087]" />
                    </div>
                    <span className="font-medium text-foreground text-sm">{cls.name}</span>
                  </div>
                  <span className="text-sm text-muted-foreground">
                    {cls.grade_level === "KG" ? "KG" : `Grade ${cls.grade_level}`}
                  </span>
                  <Badge variant="secondary" className="text-xs">
                    Section {cls.section}
                  </Badge>
                  <div className="flex items-center gap-1.5 text-sm text-muted-foreground">
                    <Users className="w-3.5 h-3.5" />
                    {cls.capacity ?? "—"}
                  </div>
                  <span className="text-sm text-muted-foreground truncate max-w-full">
                    {cls.teacher?.full_name || "Unassigned"}
                  </span>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  );
}
