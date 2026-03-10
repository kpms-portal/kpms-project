'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

interface ChildForm {
  full_name: string;
  grade: string;
  section: string;
  date_of_birth: string;
}

const GRADES = ['Pre-K', 'KG', '1', '2', '3', '4', '5', '6', '7', '8'];
const SECTIONS = ['A', 'B'];

function emptyChild(): ChildForm {
  return { full_name: '', grade: '', section: 'A', date_of_birth: '' };
}

export default function RegisterPage() {
  const router = useRouter();
  const [step, setStep] = useState(1);

  // Parent fields
  const [fullName, setFullName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);

  // Children
  const [children, setChildren] = useState<ChildForm[]>([emptyChild()]);

  // State
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function handleNextStep(e: React.FormEvent) {
    e.preventDefault();
    setError(null);

    const checks = {
      length: password.length >= 8,
      upper: /[A-Z]/.test(password),
      lower: /[a-z]/.test(password),
      number: /[0-9]/.test(password),
      special: /[^A-Za-z0-9]/.test(password),
    };

    if (!checks.length) { setError('Password must be at least 8 characters.'); return; }
    if (!checks.upper) { setError('Password must contain at least one uppercase letter.'); return; }
    if (!checks.lower) { setError('Password must contain at least one lowercase letter.'); return; }
    if (!checks.number) { setError('Password must contain at least one number.'); return; }
    if (!checks.special) { setError('Password must contain at least one special character (!@#$%^&*...).'); return; }
    if (password !== confirmPassword) { setError('Passwords do not match.'); return; }

    setStep(2);
  }

  function updateChild(index: number, field: keyof ChildForm, value: string) {
    setChildren((prev) =>
      prev.map((child, i) =>
        i === index ? { ...child, [field]: value } : child
      )
    );
  }

  function addChild() {
    setChildren((prev) => [...prev, emptyChild()]);
  }

  function removeChild(index: number) {
    if (children.length <= 1) return;
    setChildren((prev) => prev.filter((_, i) => i !== index));
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);

    // Validate at least one child has required fields
    const validChildren = children.filter(
      (c) => c.full_name.trim() && c.grade
    );
    if (validChildren.length === 0) {
      setError('Please add at least one child with a name and grade.');
      return;
    }

    setLoading(true);

    try {
      const res = await fetch('/api/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email,
          password,
          full_name: fullName,
          phone,
          children: validChildren,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.error || 'Registration failed. Please try again.');
        setLoading(false);
        return;
      }

      // Redirect to login with success message
      router.push('/auth/login?registered=true');
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
      <div className="w-full max-w-lg">
        {/* Card */}
        <div className="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
          {/* Logo Area */}
          <div className="flex flex-col items-center mb-6">
            <h1
              className="text-4xl font-bold tracking-tight"
              style={{ fontFamily: 'var(--font-playfair), serif' }}
            >
              <span className="text-[#003087]">KP</span>
              <span className="text-[#FFD100]">MS</span>
            </h1>
            <p className="text-sm text-[#5a6577] mt-1">Parent Registration</p>
            <div className="w-12 h-1 bg-[#FFD100] rounded-full mt-3" />
          </div>

          {/* Step Indicator */}
          <div className="flex items-center justify-center gap-3 mb-8">
            <div className="flex items-center gap-2">
              <div
                className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold ${
                  step >= 1
                    ? 'bg-[#003087] text-white'
                    : 'bg-[#e2e8f0] text-[#5a6577]'
                }`}
              >
                1
              </div>
              <span className="text-xs font-medium text-[#1a1a2e] hidden sm:inline">
                Parent Info
              </span>
            </div>
            <div className="w-8 h-px bg-[#e2e8f0]" />
            <div className="flex items-center gap-2">
              <div
                className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold ${
                  step >= 2
                    ? 'bg-[#003087] text-white'
                    : 'bg-[#e2e8f0] text-[#5a6577]'
                }`}
              >
                2
              </div>
              <span className="text-xs font-medium text-[#1a1a2e] hidden sm:inline">
                Children
              </span>
            </div>
          </div>

          {/* Error Display */}
          {error && (
            <div className="mb-6 p-3 rounded-xl bg-[#E8443A]/10 border border-[#E8443A]/20 text-[#E8443A] text-sm text-center">
              {error}
            </div>
          )}

          {/* Step 1: Parent Info */}
          {step === 1 && (
            <form onSubmit={handleNextStep} className="space-y-4">
              <div>
                <label
                  htmlFor="fullName"
                  className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
                >
                  Full Name
                </label>
                <input
                  id="fullName"
                  type="text"
                  required
                  autoComplete="name"
                  placeholder="Your full name"
                  value={fullName}
                  onChange={(e) => setFullName(e.target.value)}
                  className="w-full px-4 py-3 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                />
              </div>

              <div>
                <label
                  htmlFor="regEmail"
                  className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
                >
                  Email Address
                </label>
                <input
                  id="regEmail"
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
                  htmlFor="regPhone"
                  className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
                >
                  Phone Number
                </label>
                <input
                  id="regPhone"
                  type="tel"
                  autoComplete="tel"
                  placeholder="+92 300 1234567"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  className="w-full px-4 py-3 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                />
              </div>

              <div>
                <label
                  htmlFor="regPassword"
                  className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
                >
                  Password
                </label>
                <div className="relative">
                  <input
                    id="regPassword"
                    type={showPassword ? 'text' : 'password'}
                    required
                    autoComplete="new-password"
                    placeholder="Min. 8 characters, mixed case, number, special"
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
                    <EyeIcon open={showPassword} />
                  </button>
                </div>
              </div>

              <div>
                <label
                  htmlFor="confirmPassword"
                  className="block text-sm font-medium text-[#1a1a2e] mb-1.5"
                >
                  Confirm Password
                </label>
                <div className="relative">
                  <input
                    id="confirmPassword"
                    type={showConfirm ? 'text' : 'password'}
                    required
                    autoComplete="new-password"
                    placeholder="Re-enter your password"
                    value={confirmPassword}
                    onChange={(e) => setConfirmPassword(e.target.value)}
                    className={`w-full px-4 py-3 pr-11 rounded-xl border text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 transition-all ${
                      confirmPassword && password !== confirmPassword
                        ? 'border-[#E8443A] bg-[#E8443A]/5 focus:ring-[#E8443A]/30'
                        : 'border-[#e2e8f0] bg-white focus:ring-[#003087]/30 focus:border-[#003087]'
                    }`}
                  />
                  <button
                    type="button"
                    onClick={() => setShowConfirm(!showConfirm)}
                    className="absolute right-3 top-1/2 -translate-y-1/2 text-[#5a6577] hover:text-[#1a1a2e] transition-colors"
                    aria-label={showConfirm ? 'Hide password' : 'Show password'}
                  >
                    <EyeIcon open={showConfirm} />
                  </button>
                </div>
                {confirmPassword && password !== confirmPassword && (
                  <p className="mt-1 text-xs text-[#E8443A]">Passwords do not match</p>
                )}
              </div>

              <button
                type="submit"
                className="w-full py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 transition-all"
              >
                Next: Add Children
              </button>
            </form>
          )}

          {/* Step 2: Children */}
          {step === 2 && (
            <form onSubmit={handleSubmit} className="space-y-6">
              {children.map((child, index) => (
                <div
                  key={index}
                  className="p-4 rounded-2xl border border-[#e2e8f0] bg-[#f8fafc] space-y-3"
                >
                  <div className="flex items-center justify-between mb-1">
                    <h3
                      className="text-sm font-semibold text-[#003087]"
                      style={{ fontFamily: 'var(--font-playfair), serif' }}
                    >
                      Child {index + 1}
                    </h3>
                    {children.length > 1 && (
                      <button
                        type="button"
                        onClick={() => removeChild(index)}
                        className="text-xs text-[#E8443A] hover:underline"
                      >
                        Remove
                      </button>
                    )}
                  </div>

                  <div>
                    <label
                      htmlFor={`childName-${index}`}
                      className="block text-sm font-medium text-[#1a1a2e] mb-1"
                    >
                      Full Name
                    </label>
                    <input
                      id={`childName-${index}`}
                      type="text"
                      required
                      placeholder="Child's full name"
                      value={child.full_name}
                      onChange={(e) =>
                        updateChild(index, 'full_name', e.target.value)
                      }
                      className="w-full px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] placeholder-[#5a6577]/50 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                    />
                  </div>

                  <div className="grid grid-cols-2 gap-3">
                    <div>
                      <label
                        htmlFor={`childGrade-${index}`}
                        className="block text-sm font-medium text-[#1a1a2e] mb-1"
                      >
                        Grade
                      </label>
                      <select
                        id={`childGrade-${index}`}
                        required
                        value={child.grade}
                        onChange={(e) =>
                          updateChild(index, 'grade', e.target.value)
                        }
                        className="w-full px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                      >
                        <option value="">Select grade</option>
                        {GRADES.map((g) => (
                          <option key={g} value={g}>
                            {g}
                          </option>
                        ))}
                      </select>
                    </div>

                    <div>
                      <label
                        htmlFor={`childSection-${index}`}
                        className="block text-sm font-medium text-[#1a1a2e] mb-1"
                      >
                        Section
                      </label>
                      <select
                        id={`childSection-${index}`}
                        value={child.section}
                        onChange={(e) =>
                          updateChild(index, 'section', e.target.value)
                        }
                        className="w-full px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                      >
                        {SECTIONS.map((s) => (
                          <option key={s} value={s}>
                            {s}
                          </option>
                        ))}
                      </select>
                    </div>
                  </div>

                  <div>
                    <label
                      htmlFor={`childDob-${index}`}
                      className="block text-sm font-medium text-[#1a1a2e] mb-1"
                    >
                      Date of Birth
                    </label>
                    <input
                      id={`childDob-${index}`}
                      type="date"
                      value={child.date_of_birth}
                      onChange={(e) =>
                        updateChild(index, 'date_of_birth', e.target.value)
                      }
                      className="w-full px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all"
                    />
                  </div>
                </div>
              ))}

              <button
                type="button"
                onClick={addChild}
                className="w-full py-2.5 px-4 rounded-xl border-2 border-dashed border-[#003087]/30 text-[#003087] font-medium text-sm hover:border-[#003087]/60 hover:bg-[#003087]/5 focus:outline-none transition-all"
              >
                + Add Another Child
              </button>

              <div className="flex gap-3">
                <button
                  type="button"
                  onClick={() => setStep(1)}
                  className="flex-1 py-3 px-4 rounded-xl border border-[#e2e8f0] text-[#5a6577] font-semibold text-sm hover:bg-[#f8fafc] focus:outline-none transition-all"
                >
                  Back
                </button>
                <button
                  type="submit"
                  disabled={loading}
                  className="flex-[2] py-3 px-4 rounded-xl bg-[#003087] text-white font-semibold text-sm hover:bg-[#002570] focus:outline-none focus:ring-2 focus:ring-[#003087]/50 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all"
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
                      Registering...
                    </span>
                  ) : (
                    'Complete Registration'
                  )}
                </button>
              </div>
            </form>
          )}

          {/* Login Link */}
          <div className="mt-6 text-center">
            <p className="text-sm text-[#5a6577]">
              Already have an account?{' '}
              <Link
                href="/auth/login"
                className="text-[#003087] font-semibold hover:underline"
              >
                Login here
              </Link>
            </p>
          </div>
        </div>

        {/* Footer */}
        <p className="text-center text-xs text-white/50 mt-6">
          KPMS School Portal
        </p>
      </div>
    </div>
  );
}
