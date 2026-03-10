import { redirect } from "next/navigation";
import { createServerSupabase } from "@/lib/supabase/server";
import { AppShell } from "@/components/layout/app-shell";

export default async function StudentLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  if (!user) {
    redirect("/login");
  }

  const { data: profile } = await supabase
    .from("profiles")
    .select("*")
    .eq("id", user.id)
    .single();

  if (!profile) {
    redirect("/login");
  }

  // Get the student record linked to this user account
  const { data: studentAccount } = await supabase
    .from("student_accounts")
    .select("student_id")
    .eq("user_id", user.id)
    .single();

  if (!studentAccount) {
    redirect("/login");
  }

  return (
    <AppShell role="student" userName={profile.full_name}>
      {children}
    </AppShell>
  );
}
