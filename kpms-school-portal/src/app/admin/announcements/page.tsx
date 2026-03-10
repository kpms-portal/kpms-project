import { createServerSupabase } from "@/lib/supabase/server";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { EmptyState } from "@/components/ui/empty-state";
import { Megaphone } from "lucide-react";
import { formatDate } from "@/lib/utils";
import type { Announcement } from "@/types";

const priorityVariant: Record<string, "secondary" | "warning" | "destructive"> = {
  normal: "secondary",
  important: "warning",
  urgent: "destructive",
};

const priorityColors: Record<string, string> = {
  normal: "#5a6577",
  important: "#F59E0B",
  urgent: "#E8443A",
};

export default async function AnnouncementsPage() {
  const supabase = await createServerSupabase();

  const { data } = await supabase
    .from("announcements")
    .select("id, title, message, priority, target_grades, created_at")
    .order("created_at", { ascending: false });

  const announcements = (data || []) as Announcement[];

  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-[#003087]/10 flex items-center justify-center">
            <Megaphone className="w-5 h-5 text-[#003087]" />
          </div>
          <div>
            <h1 className="font-heading text-2xl font-bold text-foreground">Announcements</h1>
            <p className="text-sm text-muted-foreground mt-0.5">
              {announcements.length} announcement{announcements.length !== 1 ? "s" : ""}
            </p>
          </div>
        </div>
      </div>

      {/* Announcements List */}
      {announcements.length === 0 ? (
        <Card>
          <CardContent className="p-0">
            <EmptyState
              icon={<Megaphone className="h-12 w-12" />}
              title="No announcements"
              description="There are no announcements yet. Create one to notify parents, teachers, and students."
            />
          </CardContent>
        </Card>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {announcements.map((ann) => (
            <Card key={ann.id} className="hover:shadow-md transition-shadow">
              <CardContent className="p-5">
                <div className="flex items-start gap-3">
                  <div
                    className="w-2 h-2 rounded-full mt-2 shrink-0"
                    style={{ backgroundColor: priorityColors[ann.priority] || "#5a6577" }}
                  />
                  <div className="min-w-0 flex-1">
                    <div className="flex items-center justify-between gap-2">
                      <h3 className="font-semibold text-foreground">{ann.title}</h3>
                      <Badge
                        variant={priorityVariant[ann.priority] || "secondary"}
                        className="text-[10px] shrink-0 capitalize"
                      >
                        {ann.priority}
                      </Badge>
                    </div>
                    {ann.message && (
                      <p className="text-sm text-muted-foreground mt-1 line-clamp-3">
                        {ann.message}
                      </p>
                    )}
                    <div className="flex items-center gap-3 mt-3">
                      <p className="text-xs text-muted-foreground">
                        {formatDate(ann.created_at)}
                      </p>
                      {ann.target_grades && ann.target_grades.length > 0 && (
                        <Badge variant="outline" className="text-[10px]">
                          Grades: {ann.target_grades.join(", ")}
                        </Badge>
                      )}
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>
      )}
    </div>
  );
}
