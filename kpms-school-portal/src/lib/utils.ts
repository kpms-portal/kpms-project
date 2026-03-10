import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function formatDate(date: string | Date): string {
  return new Date(date).toLocaleDateString('en-PK', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
}

export function formatTime(date: string | Date): string {
  return new Date(date).toLocaleTimeString('en-PK', {
    hour: '2-digit',
    minute: '2-digit',
  });
}

export function getInitials(name: string): string {
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2);
}

export function getAttendanceColor(status: string): string {
  switch (status) {
    case 'present':
      return '#0A8F6C';
    case 'absent':
      return '#E8443A';
    case 'late':
      return '#F59E0B';
    case 'excused':
      return '#3B82F6';
    default:
      return '#9CA3AF';
  }
}

export function getGradeColor(percent: number): string {
  if (percent >= 90) return '#0A8F6C';
  if (percent >= 80) return '#3B82F6';
  if (percent >= 70) return '#F59E0B';
  if (percent >= 60) return '#F97316';
  return '#E8443A';
}
