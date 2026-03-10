import { redirect } from "next/navigation";
import { createServerSupabase } from "@/lib/supabase/server";
import { AppShell } from "@/components/layout/app-shell";

export default async function TeacherLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  let userName = "Teacher";

  if (user) {
    const { data: profile } = await supabase
      .from("profiles")
      .select("*")
      .eq("id", user.id)
      .single();

    if (!profile || profile.role !== "teacher") {
      redirect("/auth/login");
    }

    userName = profile.full_name || "Teacher";
  }

  return (
    <AppShell
      role="teacher"
      userName={userName}
      pageTitle="Teacher Portal"
    >
      {children}
    </AppShell>
  );
}
