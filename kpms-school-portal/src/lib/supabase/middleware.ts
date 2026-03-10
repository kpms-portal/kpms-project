import { createServerClient } from '@supabase/ssr'
import { NextResponse, type NextRequest } from 'next/server'
import { createClient } from '@supabase/supabase-js'

export async function updateSession(request: NextRequest) {
  let supabaseResponse = NextResponse.next({ request })

  const supabase = createServerClient(
    process.env.NEXT_PUBLIC_SUPABASE_URL!,
    process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY!,
    {
      cookies: {
        getAll() {
          return request.cookies.getAll()
        },
        setAll(cookiesToSet) {
          cookiesToSet.forEach(({ name, value }) =>
            request.cookies.set(name, value)
          )
          supabaseResponse = NextResponse.next({ request })
          cookiesToSet.forEach(({ name, value, options }) =>
            supabaseResponse.cookies.set(name, value, options)
          )
        },
      },
    }
  )

  // Refresh session - this is what writes the cookie from the Authorization header
  // The browser client sends the access token as a cookie named sb-<project>-auth-token
  const { data: { user } } = await supabase.auth.getUser()

  const pathname = request.nextUrl.pathname

  // Public routes that never require auth
  const publicRoutes = ['/auth/login', '/auth/register', '/auth/callback', '/auth/update-password']
  const isPublicRoute = publicRoutes.some((route) => pathname.startsWith(route))

  // API routes handle their own auth
  const isApiRoute = pathname.startsWith('/api/')

  // Static assets
  const isStaticRoute = pathname.startsWith('/_next/') || pathname.includes('favicon')

  if (isStaticRoute || isApiRoute || isPublicRoute) {
    return supabaseResponse
  }

  // Check both the supabase getUser result AND the raw cookie presence
  // The cookie is set by createBrowserClient after signInWithPassword
  const authCookieName = `sb-${process.env.NEXT_PUBLIC_SUPABASE_URL!.split('//')[1].split('.')[0]}-auth-token`
  const hasAuthCookie = request.cookies.has(authCookieName) || request.cookies.has('sb-access-token')

  if (!user && !hasAuthCookie) {
    const url = request.nextUrl.clone()
    url.pathname = '/auth/login'
    return NextResponse.redirect(url)
  }

  // Use service role to bypass RLS for profile lookup
  const adminClient = createClient(
    process.env.NEXT_PUBLIC_SUPABASE_URL!,
    process.env.SUPABASE_SERVICE_ROLE_KEY!
  )

  const { data: profile } = await adminClient
    .from('profiles')
    .select('role')
    .eq('id', user?.id)
    .single()

  if (!profile) {
    // If we have a cookie but no profile, let the request through
    // (the page itself will handle auth)
    if (hasAuthCookie && !user) {
      return supabaseResponse
    }
    const url = request.nextUrl.clone()
    url.pathname = '/auth/login'
    return NextResponse.redirect(url)
  }

  // If visiting root, redirect to role dashboard
  if (pathname === '/') {
    const url = request.nextUrl.clone()
    url.pathname = `/${profile.role}`
    return NextResponse.redirect(url)
  }

  // Role-based access control
  const roleRoutes: Record<string, string> = {
    admin: '/admin',
    teacher: '/teacher',
    parent: '/parent',
    student: '/student',
  }

  const allowedPrefix = roleRoutes[profile.role]

  if (allowedPrefix && !pathname.startsWith(allowedPrefix)) {
    const url = request.nextUrl.clone()
    url.pathname = allowedPrefix
    return NextResponse.redirect(url)
  }

  return supabaseResponse
}
