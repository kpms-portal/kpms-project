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

  if (!user) {
    redirect('/auth/login');
  }

  const { data: profile } = await supabase
    .from('profiles')
    .select('full_name, role')
    .eq('id', user.id)
    .single();

  if (!profile || profile.role !== 'parent') {
    redirect('/auth/login');
  }

  return (
    <AppShell role="parent" userName={profile.full_name}>
      {children}
    </AppShell>
  );
}
