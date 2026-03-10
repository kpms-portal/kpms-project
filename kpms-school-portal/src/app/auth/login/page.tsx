'use client';

import { useState, Suspense } from 'react';
import { useRouter, useSearchParams } from 'next/navigation';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

function LoginForm() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const registered = searchParams.get('registered') === 'true';
  const resetError = searchParams.get('error') === 'invalid_reset_link';

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [showForgot, setShowForgot] = useState(false);
  const [forgotEmail, setForgotEmail] = useState('');
  const [forgotLoading, setForgotLoading] = useState(false);
  const [forgotSent, setForgotSent] = useState(false);
  const [forgotError, setForgotError] = useState<string | null>(null);

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);
    setLoading(true);

    try {
      const supabase = createClient()
      const { data, error: authError } = await supabase.auth.signInWithPassword({
        email,
        password,
      })

      if (authError) {
        setError(authError.message)
        setLoading(false)
        return
      }

      // Use server API to get role (bypasses RLS cookie timing issues)
      const res = await fetch('/api/auth/me', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId: data.user.id }),
      })

      const result = await res.json()

      if (!res.ok || !result.role) {
        setError('Account setup incomplete. Please contact your administrator.')
        setLoading(false)
        return
      }

      window.location.href = `/${result.role}`
    } catch (err) {
      setError(err instanceof Error ? err.message : 'An unexpected error occurred.')
      setLoading(false)
    }
  }

  async function handleForgotPassword(e: React.FormEvent) {
    e.preventDefault();
    setForgotError(null);
    setForgotLoading(true);

    try {
      const supabase = createClient();
      const { error } = await supabase.auth.resetPasswordForEmail(forgotEmail, {
        redirectTo: `${window.location.origin}/auth/callback`,
      });

      if (error) {
        setForgotError(error.message);
        setForgotLoading(false);
        return;
      }

      setForgotSent(true);
      setForgotLoading(false);
    } catch {
      setForgotError('An unexpected error occurred. Please try again.');
      setForgotLoading(false);
    }
  }

  return (
    <div className="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
      {/* Logo Area */}
      <div className="flex flex-col items-center mb-8">
        <div className="mb-3">
          <h1 className="text-5xl font-bold tracking-tight" style={{ fontFamily: 'var(--font-playfair), serif' }}>
            <span className="text-[#003087]">KP</span>
            <span className="text-[#FFD100]">MS</span>
          </h1>
        </div>
        <p className="text-sm text-[#5a6577]">Kamal Public Middle School</p>
        <div className="w-12 h-1 bg-[#FFD100] rounded-full mt-3" />
      </div>

      {registered && (
        <div className="mb-6 p-3 rounded-xl bg-[#0A8F6C]/10 border border-[#0A8F6C]/20 text-[#0A8F6C] text-sm text-center">
          Registration successful! Please log in with your credentials.
        </div>
      )}

      {resetError && (
        <div className="mb-6 p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
          That reset link is invalid or has expired. Please request a new one.
        </div>
      )}

      {error && (
        <div className="mb-6 p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
          {error}
        </div>
      )}

      {/* Forgot Password Panel */}
      {showForgot ? (
        <div>
          <h2 className="text-lg font-semibold text-[#1a1a2e] mb-2" style={{ fontFamily: 'var(--font-playfair), serif' }}>
            Reset Password
          </h2>
          <p className="text-sm text-[#5a6577] mb-5">
            Enter your email and we&apos;ll send you a link to set a new password.
          </p>

          {forgotSent ? (
            <div className="p-4 rounded-xl bg-[#0A8F6C]/10 border border-[#0A8F6C]/20 text-[#0A8F6C] text-sm text-center">
              Reset email sent! Check your inbox and click the link to set a new password.
            </div>
          ) : (
            <form onSubmit={handleForgotPassword} className="space-y-4">
              {forgotError && (
                <div className="p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
                  {forgotError}
                </div>
              )}
              <div>
                <label htmlFor="forgotEmail" className="block text-sm font-medium text-[#1a1a2e] mb-1.5">
                  Email Address
                </label>
                <input
                  id="forgotEmail"
                  type="email"
                  required
                  autoComplete="email"
                  placeholder="your@email.com"
                  value={forgotEmail}
                  onChange={(e) => setForgotEmail(e.target.value)}
                  className="w-full px-4 py-3 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                />
              </div>
              <button
                type="submit"
                disabled={forgotLoading}
                className="w-full py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all"
              >
                {forgotLoading ? 'Sending...' : 'Send Reset Email'}
              </button>
            </form>
          )}

          <button
            type="button"
            onClick={() => { setShowForgot(false); setForgotSent(false); setForgotError(null); }}
            className="mt-4 w-full text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors"
          >
            &larr; Back to Login
          </button>
        </div>
      ) : (
        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label htmlFor="email" className="block text-sm font-medium text-[#1a1a2e] mb-1.5" style={{ fontFamily: 'var(--font-dm-sans), sans-serif' }}>
              Email Address
            </label>
            <input
              id="email"
              type="email"
              required
              autoComplete="email"
              placeholder="parent@example.com"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="w-full px-4 py-3 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
            />
          </div>

          <div>
            <div className="flex items-center justify-between mb-1.5">
              <label htmlFor="password" className="block text-sm font-medium text-[#1a1a2e]" style={{ fontFamily: 'var(--font-dm-sans), sans-serif' }}>
                Password
              </label>
              <button
                type="button"
                onClick={() => { setShowForgot(true); setForgotEmail(email); }}
                className="text-xs text-[#003087] hover:underline font-medium"
              >
                Forgot password?
              </button>
            </div>
            <div className="relative">
              <input
                id="password"
                type={showPassword ? 'text' : 'password'}
                required
                autoComplete="current-password"
                placeholder="Enter your password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full px-4 py-3 pr-11 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-[#5a6577] hover:text-[#1a1a2e] transition-colors"
                aria-label={showPassword ? 'Hide password' : 'Show password'}
              >
                {showPassword ? (
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                    <line x1="1" y1="1" x2="23" y2="23" />
                  </svg>
                ) : (
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                  </svg>
                )}
              </button>
            </div>
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all"
          >
            {loading ? (
              <span className="flex items-center justify-center gap-2">
                <svg className="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                  <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                </svg>
                Signing in...
              </span>
            ) : 'Login'}
          </button>
        </form>
      )}

      {!showForgot && (
        <div className="mt-6 text-center">
          <p className="text-sm text-[#5a6577]">
            New parent?{' '}
            <Link href="/auth/register" className="text-[#003087] font-semibold hover:underline">
              Register here
            </Link>
          </p>
        </div>
      )}
    </div>
  );
}

export default function LoginPage() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#003087] via-[#002060] to-[#001540] px-4 py-8">
      <div className="w-full max-w-md">
        <Suspense
          fallback={
            <div className="bg-white rounded-2xl shadow-2xl p-8 sm:p-10 flex items-center justify-center min-h-[400px]">
              <div className="animate-spin h-8 w-8 border-4 border-[#003087] border-t-transparent rounded-full" />
            </div>
          }
        >
          <LoginForm />
        </Suspense>

        {/* Footer */}
        <p className="text-center text-xs text-white/50 mt-6">
          KPMS School Portal
        </p>
      </div>
    </div>
  );
}
