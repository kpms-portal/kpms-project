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

  let userName = "Student";

  if (user) {
    const { data: profile } = await supabase
      .from("profiles")
      .select("*")
      .eq("id", user.id)
      .single();

    if (!profile) {
      redirect("/auth/login");
    }

    userName = profile.full_name || "Student";

    // Get the student record linked to this user account
    const { data: studentAccount } = await supabase
      .from("student_accounts")
      .select("student_id")
      .eq("user_id", user.id)
      .single();

    if (!studentAccount) {
      redirect("/auth/login");
    }
  }

  return (
    <AppShell role="student" userName={userName}>
      {children}
    </AppShell>
  );
}
