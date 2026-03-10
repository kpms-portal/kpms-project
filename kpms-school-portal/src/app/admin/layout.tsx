import { redirect } from "next/navigation";
import { createServerSupabase, createServiceRoleClient } from "@/lib/supabase/server";
import { AppShell } from "@/components/layout/app-shell";

export default async function AdminLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const supabase = await createServerSupabase();
  const adminClient = createServiceRoleClient();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  let userName = "Admin";

  if (user) {
    const { data: profile } = await adminClient
      .from("profiles")
      .select("full_name, role")
      .eq("id", user.id)
      .single();

    if (!profile || profile.role !== "admin") {
      redirect("/auth/login");
    }

    userName = profile.full_name || "Admin";
  }

  return (
    <AppShell role="admin" userName={userName}>
      {children}
    </AppShell>
  );
}
