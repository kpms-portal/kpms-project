import { redirect } from 'next/navigation';
import { createServerSupabase } from '@/lib/supabase/server';
import { AppShell } from '@/components/layout/app-shell';

export default async function ParentLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const supabase = await createServerSupabase();

  const {
    data: { user },
  } = await supabase.auth.getUser();

  let userName = "Parent";

  if (user) {
    const { data: profile } = await supabase
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
