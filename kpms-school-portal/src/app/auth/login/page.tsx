'use client';

import { useState, Suspense } from 'react';
import { useRouter, useSearchParams } from 'next/navigation';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

function LoginForm() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const registered = searchParams.get('registered') === 'true';

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);
    setLoading(true);

    try {
      const supabase = createClient();
      const { error: authError } = await supabase.auth.signInWithPassword({
        email,
        password,
      });

      if (authError) {
        setError(authError.message);
        setLoading(false);
        return;
      }

      // Middleware handles role-based routing on redirect to /
      router.push('/');
      router.refresh();
    } catch {
      setError('An unexpected error occurred. Please try again.');
      setLoading(false);
    }
  }

  return (
    <div className="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
      {/* Logo Area */}
      <div className="flex flex-col items-center mb-8">
        <div className="mb-3">
          <h1
            className="text-5xl font-bold tracking-tight"
            style={{ fontFamily: 'var(--font-playfair), serif' }}
          >
            <span className="text-[#003087]">KP</span>
            <span className="text-[#FFD100]">MS</span>
          </h1>
        </div>
        <p className="text-sm text-[#5a6577]">
          Kamal Public Middle School
        </p>
        <div className="w-12 h-1 bg-[#FFD100] rounded-full mt-3" />
      </div>

      {/* Success message from registration */}
      {registered && (
        <div className="mb-6 p-3 rounded-xl bg-[#0A8F6C]/10 border border-[#0A8F6C]/20 text-[#0A8F6C] text-sm text-center">
          Registration successful! Please log in with your credentials.
        </div>
      )}

      {/* Error Display */}
      {error && (
        <div className="mb-6 p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
          {error}
        </div>
      )}

      {/* Login Form */}
      <form onSubmit={handleSubmit} className="space-y-5">
        <div>
          <label
            htmlFor="email"
            className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
            style={{ fontFamily: 'var(--font-dm-sans), sans-serif' }}
          >
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
          <label
            htmlFor="password"
            className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
            style={{ fontFamily: 'var(--font-dm-sans), sans-serif' }}
          >
            Password
          </label>
          <input
            id="password"
            type="password"
            required
            autoComplete="current-password"
            placeholder="Enter your password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="w-full px-4 py-3 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
          />
        </div>

        <button
          type="submit"
          disabled={loading}
          className="w-full py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all"
        >
          {loading ? (
            <span className="flex items-center justify-center gap-2">
              <svg
                className="animate-spin h-4 w-4 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  className="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  strokeWidth="4"
                />
                <path
                  className="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                />
              </svg>
              Signing in...
            </span>
          ) : (
            'Login'
          )}
        </button>
      </form>

      {/* Register Link */}
      <div className="mt-6 text-center">
        <p className="text-sm text-[#5a6577]">
          New parent?{' '}
          <Link
            href="/auth/register"
            className="text-[#003087] font-semibold hover:underline"
          >
            Register here
          </Link>
        </p>
      </div>
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
