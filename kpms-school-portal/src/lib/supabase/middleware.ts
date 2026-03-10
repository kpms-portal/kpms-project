import { createServerClient } from '@supabase/ssr';
import { NextResponse, type NextRequest } from 'next/server';

export async function updateSession(request: NextRequest) {
  let supabaseResponse = NextResponse.next({ request });

  const supabase = createServerClient(
    process.env.NEXT_PUBLIC_SUPABASE_URL!,
    process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY!,
    {
      cookies: {
        getAll() {
          return request.cookies.getAll();
        },
        setAll(cookiesToSet) {
          cookiesToSet.forEach(({ name, value, options }) =>
            request.cookies.set(name, value)
          );
          supabaseResponse = NextResponse.next({ request });
          cookiesToSet.forEach(({ name, value, options }) =>
            supabaseResponse.cookies.set(name, value, options)
          );
        },
      },
    }
  );

  const {
    data: { user },
  } = await supabase.auth.getUser();

  const pathname = request.nextUrl.pathname;

  // Public routes that don't require auth
  const publicRoutes = ['/', '/auth/login', '/auth/register', '/auth/callback'];
  const isPublicRoute = publicRoutes.some((route) => pathname === route);

  if (!user && !isPublicRoute) {
    const url = request.nextUrl.clone();
    url.pathname = '/auth/login';
    return NextResponse.redirect(url);
  }

  if (user && (pathname === '/' || pathname === '/auth/login')) {
    // Fetch user role and redirect to their dashboard
    const { data: profile } = await supabase
      .from('profiles')
      .select('role')
      .eq('id', user.id)
      .single();

    if (profile) {
      const url = request.nextUrl.clone();
      url.pathname = `/${profile.role}`;
      return NextResponse.redirect(url);
    }
  }

  // Check role-based route access
  const roleRoutes: Record<string, string[]> = {
    admin: ['/admin'],
    teacher: ['/teacher'],
    parent: ['/parent'],
    student: ['/student'],
  };

  if (user && !isPublicRoute) {
    const { data: profile } = await supabase
      .from('profiles')
      .select('role')
      .eq('id', user.id)
      .single();

    if (profile) {
      const allowedPrefixes = roleRoutes[profile.role] || [];
      const isApiRoute = pathname.startsWith('/api');
      const isAllowed =
        isApiRoute || allowedPrefixes.some((prefix) => pathname.startsWith(prefix));

      if (!isAllowed) {
        const url = request.nextUrl.clone();
        url.pathname = `/${profile.role}`;
        return NextResponse.redirect(url);
      }
    }
  }

  return supabaseResponse;
}
