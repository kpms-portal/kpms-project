'use client';

import { useRouter } from 'next/navigation';
import type { Student } from '@/types';

interface ProfileChildSelectorProps {
  studentList: Student[];
  selectedChildId: string;
}

export function ProfileChildSelector({
  studentList,
  selectedChildId,
}: ProfileChildSelectorProps) {
  const router = useRouter();

  return (
    <select
      value={selectedChildId}
      onChange={(e) => router.push(`/parent/profile?child=${e.target.value}`)}
      className="h-10 rounded-xl border border-[#e2e8f0] bg-white px-4 text-sm font-medium text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/20 focus:border-[#003087]"
    >
      {studentList.map((child) => (
        <option key={child.id} value={child.id}>
          {child.full_name}
        </option>
      ))}
    </select>
  );
}
