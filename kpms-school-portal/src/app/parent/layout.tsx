import { redirect } from 'next/navigation';
import { createServerSupabase, createServiceRoleClient } from '@/lib/supabase/server';
import { AppShell } from '@/components/layout/app-shell';

export default async function ParentLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const supabase = await createServerSupabase();
  const adminClient = createServiceRoleClient();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  let userName = "Parent";

  if (user) {
    const { data: profile } = await adminClient
      .from('profiles')
      .select('full_name, role')
      .eq('id', user.id)
      .single();

    if (!profile || profile.role !== 'parent') {
      redirect('/auth/login');
    }

    userName = profile.full_name || "Parent";
  }

  return (
    <AppShell role="parent" userName={userName}>
      {children}
    </AppShell>
  );
}
