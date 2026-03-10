'use client';

import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';
import { createClient } from '@/lib/supabase/client';

function PasswordCheck({ met, label }: { met: boolean; label: string }) {
  return (
    <div className={`flex items-center gap-2 text-xs ${met ? 'text-[#0A8F6C]' : 'text-[#5a6577]'}`}>
      <span className={`w-4 h-4 rounded-full flex items-center justify-center text-white text-[10px] flex-shrink-0 ${met ? 'bg-[#0A8F6C]' : 'bg-[#e2e8f0]'}`}>
        {met ? '\u2713' : ''}
      </span>
      {label}
    </div>
  );
}

export default function UpdatePasswordPage() {
  const router = useRouter();
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState(false);

  const checks = {
    length: password.length >= 8,
    upper: /[A-Z]/.test(password),
    lower: /[a-z]/.test(password),
    number: /[0-9]/.test(password),
    special: /[^A-Za-z0-9]/.test(password),
  };
  const allMet = Object.values(checks).every(Boolean);

  useEffect(() => {
    if (success) {
      const timer = setTimeout(() => router.push('/auth/login'), 2500);
      return () => clearTimeout(timer);
    }
  }, [success, router]);

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);

    if (!allMet) { setError('Password does not meet all requirements.'); return; }
    if (password !== confirmPassword) { setError('Passwords do not match.'); return; }

    setLoading(true);

    try {
      const supabase = createClient();
      const { error: updateError } = await supabase.auth.updateUser({ password });

      if (updateError) { setError(updateError.message); setLoading(false); return; }
      setSuccess(true);
    } catch {
      setError('An unexpected error occurred. Please try again.');
      setLoading(false);
    }
  }

  const EyeIcon = ({ open }: { open: boolean }) => open ? (
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
  );

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#003087] via-[#002060] to-[#001540] px-4 py-8">
      <div className="w-full max-w-md">
        <div className="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
          <div className="flex flex-col items-center mb-8">
            <h1 className="text-5xl font-bold tracking-tight" style={{ fontFamily: 'var(--font-playfair), serif' }}>
              <span className="text-[#003087]">KP</span>
              <span className="text-[#FFD100]">MS</span>
            </h1>
            <p className="text-sm text-[#5a6577] mt-1">Set New Password</p>
            <div className="w-12 h-1 bg-[#FFD100] rounded-full mt-3" />
          </div>

          {success ? (
            <div className="text-center py-4">
              <div className="w-16 h-16 rounded-full bg-[#0A8F6C]/10 flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-[#0A8F6C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p className="text-[#0A8F6C] font-semibold text-lg mb-1">Password Updated!</p>
              <p className="text-sm text-[#5a6577]">Redirecting you to login...</p>
            </div>
          ) : (
            <form onSubmit={handleSubmit} className="space-y-5">
              {error && (
                <div className="p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
                  {error}
                </div>
              )}

              <div>
                <label htmlFor="newPassword" className="block text-sm font-medium text-[#1a1a2e] mb-1.5">
                  New Password
                </label>
                <div className="relative">
                  <input
                    id="newPassword"
                    type={showPassword ? 'text' : 'password'}
                    required
                    autoComplete="new-password"
                    placeholder="Enter new password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full px-4 py-3 pr-11 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                  />
                  <button type="button" onClick={() => setShowPassword(!showPassword)} className="absolute right-3 top-1/2 -translate-y-1/2 text-[#5a6577] hover:text-[#1a1a2e] transition-colors">
                    <EyeIcon open={showPassword} />
                  </button>
                </div>
              </div>

              {password.length > 0 && (
                <div className="p-3 rounded-xl bg-[#f8fafc] border border-[#e2e8f0] space-y-1.5">
                  <PasswordCheck met={checks.length} label="At least 8 characters" />
                  <PasswordCheck met={checks.upper} label="One uppercase letter (A-Z)" />
                  <PasswordCheck met={checks.lower} label="One lowercase letter (a-z)" />
                  <PasswordCheck met={checks.number} label="One number (0-9)" />
                  <PasswordCheck met={checks.special} label="One special character (!@#$...)" />
                </div>
              )}

              <div>
                <label htmlFor="confirmPassword" className="block text-sm font-medium text-[#1a1a2e] mb-1.5">
                  Confirm Password
                </label>
                <div className="relative">
                  <input
                    id="confirmPassword"
                    type={showConfirm ? 'text' : 'password'}
                    required
                    autoComplete="new-password"
                    placeholder="Re-enter new password"
                    value={confirmPassword}
                    onChange={(e) => setConfirmPassword(e.target.value)}
                    className={`w-full px-4 py-3 pr-11 rounded-xl border text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 transition-all ${
                      confirmPassword && password !== confirmPassword
                        ? 'border-[#E8443A] bg-[#E8443A]/5 focus:ring-[#E8443A]/30'
                        : 'border-[#e2e8f0] bg-white focus:ring-[#003087]/30 focus:border-[#003087]'
                    }`}
                  />
                  <button type="button" onClick={() => setShowConfirm(!showConfirm)} className="absolute right-3 top-1/2 -translate-y-1/2 text-[#5a6577] hover:text-[#1a1a2e] transition-colors">
                    <EyeIcon open={showConfirm} />
                  </button>
                </div>
                {confirmPassword && password !== confirmPassword && (
                  <p className="mt-1 text-xs text-[#E8443A]">Passwords do not match</p>
                )}
              </div>

              <button
                type="submit"
                disabled={loading || !allMet || password !== confirmPassword}
                className="w-full py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all"
              >
                {loading ? 'Updating...' : 'Set New Password'}
              </button>
            </form>
          )}
        </div>
        <p className="text-center text-xs text-white/50 mt-6">KPMS School Portal</p>
      </div>
    </div>
  );
}
