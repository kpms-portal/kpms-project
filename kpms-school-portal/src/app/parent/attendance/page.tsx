'use client';

import { useEffect, useState, useCallback } from 'react';
import { createClient } from '@/lib/supabase/client';
import { Card, CardContent } from '@/components/ui/card';
import { LoadingState } from '@/components/ui/loading-state';
import { EmptyState } from '@/components/ui/empty-state';
import {
  ChevronLeft,
  ChevronRight,
  CalendarCheck,
  CalendarX2,
  Clock,
  ShieldCheck,
  Calendar,
} from 'lucide-react';
import type { Student, AttendanceRecord } from '@/types';

const STATUS_COLORS: Record<string, { bg: string; text: string; label: string }> = {
  present: { bg: 'bg-[#0A8F6C]', text: 'text-white', label: 'Present' },
  absent: { bg: 'bg-[#E8443A]', text: 'text-white', label: 'Absent' },
  late: { bg: 'bg-[#F59E0B]', text: 'text-white', label: 'Late' },
  excused: { bg: 'bg-[#3B82F6]', text: 'text-white', label: 'Excused' },
};

const DAY_NAMES = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const MONTH_NAMES = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December',
];

export default function AttendancePage() {
  const supabase = createClient();
  const [children, setChildren] = useState<Student[]>([]);
  const [selectedChild, setSelectedChild] = useState<string>('');
  const [records, setRecords] = useState<AttendanceRecord[]>([]);
  const [loading, setLoading] = useState(true);
  const [currentMonth, setCurrentMonth] = useState(new Date());

  // Fetch children
  useEffect(() => {
    async function fetchChildren() {
      const { data: { user } } = await supabase.auth.getUser();
      if (!user) return;

      const { data } = await supabase
        .from('students')
        .select('*')
        .eq('parent_id', user.id)
        .eq('is_active', true)
        .order('full_name');

      const list = (data || []) as Student[];
      setChildren(list);

      // Check URL for pre-selected child
      const params = new URLSearchParams(window.location.search);
      const childParam = params.get('child');
      if (childParam && list.some((c) => c.id === childParam)) {
        setSelectedChild(childParam);
      } else if (list.length > 0) {
        setSelectedChild(list[0].id);
      }
      setLoading(false);
    }
    fetchChildren();
  }, []); // eslint-disable-line react-hooks/exhaustive-deps

  // Fetch attendance for selected child + month
  const fetchAttendance = useCallback(async () => {
    if (!selectedChild) return;

    const year = currentMonth.getFullYear();
    const month = currentMonth.getMonth();
    const startDate = new Date(year, month, 1).toISOString().split('T')[0];
    const endDate = new Date(year, month + 1, 0).toISOString().split('T')[0];

    const { data } = await supabase
      .from('attendance')
      .select('*')
      .eq('student_id', selectedChild)
      .gte('date', startDate)
      .lte('date', endDate)
      .order('date');

    setRecords((data || []) as AttendanceRecord[]);
  }, [selectedChild, currentMonth]); // eslint-disable-line react-hooks/exhaustive-deps

  useEffect(() => {
    fetchAttendance();
  }, [fetchAttendance]);

  // Build calendar grid data
  const year = currentMonth.getFullYear();
  const month = currentMonth.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const recordMap: Record<string, AttendanceRecord> = {};
  records.forEach((r) => {
    recordMap[r.date] = r;
  });

  // Stats
  const totalDays = records.length;
  const presentCount = records.filter((r) => r.status === 'present').length;
  const absentCount = records.filter((r) => r.status === 'absent').length;
  const lateCount = records.filter((r) => r.status === 'late').length;
  const excusedCount = records.filter((r) => r.status === 'excused').length;
  const percentage = totalDays > 0 ? Math.round(((presentCount + lateCount) / totalDays) * 100) : 0;

  const navigateMonth = (dir: number) => {
    setCurrentMonth(new Date(year, month + dir, 1));
  };

  const selectedStudent = children.find((c) => c.id === selectedChild);

  if (loading) {
    return <LoadingState message="Loading attendance data..." />;
  }

  if (children.length === 0) {
    return (
      <div className="max-w-4xl">
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e] mb-4">Attendance</h1>
        <EmptyState icon={Calendar} message="No children linked to your account." />
      </div>
    );
  }

  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">Attendance</h1>
          <p className="text-sm text-[#5a6577] mt-1">
            {selectedStudent ? `${selectedStudent.full_name} - Grade ${selectedStudent.grade}` : 'Select a child'}
          </p>
        </div>

        {/* Child selector */}
        {children.length > 1 && (
          <select
            value={selectedChild}
            onChange={(e) => setSelectedChild(e.target.value)}
            className="h-10 rounded-xl border border-[#e2e8f0] bg-white px-4 text-sm font-medium text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/20 focus:border-[#003087]"
          >
            {children.map((child) => (
              <option key={child.id} value={child.id}>
                {child.full_name}
              </option>
            ))}
          </select>
        )}
      </div>

      {/* Stats Bar */}
      <div className="grid grid-cols-2 sm:grid-cols-5 gap-3">
        <Card>
          <CardContent className="p-4 text-center">
            <CalendarCheck className="w-5 h-5 mx-auto mb-1 text-[#5a6577]" />
            <p className="text-xl font-bold text-[#1a1a2e]">{totalDays}</p>
            <p className="text-xs text-[#5a6577]">Total Days</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4 text-center">
            <CalendarCheck className="w-5 h-5 mx-auto mb-1 text-[#0A8F6C]" />
            <p className="text-xl font-bold text-[#0A8F6C]">{presentCount}</p>
            <p className="text-xs text-[#5a6577]">Present</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4 text-center">
            <CalendarX2 className="w-5 h-5 mx-auto mb-1 text-[#E8443A]" />
            <p className="text-xl font-bold text-[#E8443A]">{absentCount}</p>
            <p className="text-xs text-[#5a6577]">Absent</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4 text-center">
            <Clock className="w-5 h-5 mx-auto mb-1 text-[#F59E0B]" />
            <p className="text-xl font-bold text-[#F59E0B]">{lateCount}</p>
            <p className="text-xs text-[#5a6577]">Late</p>
          </CardContent>
        </Card>
        <Card className="col-span-2 sm:col-span-1">
          <CardContent className="p-4 text-center">
            <ShieldCheck className="w-5 h-5 mx-auto mb-1 text-[#003087]" />
            <p className="text-xl font-bold text-[#003087]">{percentage}%</p>
            <p className="text-xs text-[#5a6577]">Attendance %</p>
          </CardContent>
        </Card>
      </div>

      {/* Calendar */}
      <Card>
        <CardContent className="p-5">
          {/* Month Navigation */}
          <div className="flex items-center justify-between mb-5">
            <button
              onClick={() => navigateMonth(-1)}
              className="p-2 rounded-lg hover:bg-[#F5F7FB] transition-colors"
              aria-label="Previous month"
            >
              <ChevronLeft className="w-5 h-5 text-[#5a6577]" />
            </button>
            <h3 className="font-heading text-lg font-semibold text-[#1a1a2e]">
              {MONTH_NAMES[month]} {year}
            </h3>
            <button
              onClick={() => navigateMonth(1)}
              className="p-2 rounded-lg hover:bg-[#F5F7FB] transition-colors"
              aria-label="Next month"
            >
              <ChevronRight className="w-5 h-5 text-[#5a6577]" />
            </button>
          </div>

          {/* Day names header */}
          <div className="grid grid-cols-7 gap-1 mb-1">
            {DAY_NAMES.map((day) => (
              <div
                key={day}
                className="text-center text-xs font-medium text-[#5a6577] py-2"
              >
                {day}
              </div>
            ))}
          </div>

          {/* Calendar grid */}
          <div className="grid grid-cols-7 gap-1">
            {/* Empty cells for days before month start */}
            {Array.from({ length: firstDay }).map((_, i) => (
              <div key={`empty-${i}`} className="aspect-square" />
            ))}

            {/* Day cells */}
            {Array.from({ length: daysInMonth }).map((_, i) => {
              const day = i + 1;
              const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
              const record = recordMap[dateStr];
              const dayOfWeek = new Date(year, month, day).getDay();
              const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;

              let cellClass = 'bg-gray-50 text-[#5a6577]'; // default/weekend/no data
              let statusLabel = '';

              if (record) {
                const statusStyle = STATUS_COLORS[record.status];
                if (statusStyle) {
                  cellClass = `${statusStyle.bg} ${statusStyle.text}`;
                  statusLabel = statusStyle.label;
                }
              } else if (isWeekend) {
                cellClass = 'bg-gray-100 text-gray-400';
              }

              const isToday =
                dateStr === new Date().toISOString().split('T')[0];

              return (
                <div
                  key={day}
                  className={`aspect-square rounded-lg flex flex-col items-center justify-center text-xs font-medium transition-colors ${cellClass} ${
                    isToday ? 'ring-2 ring-[#003087] ring-offset-1' : ''
                  }`}
                  title={
                    record
                      ? `${statusLabel}${record.notes ? ` - ${record.notes}` : ''}`
                      : isWeekend
                      ? 'Weekend'
                      : 'No data'
                  }
                >
                  <span className="text-sm font-semibold">{day}</span>
                  {record && (
                    <span className="text-[10px] leading-tight hidden sm:block">
                      {statusLabel.slice(0, 3)}
                    </span>
                  )}
                </div>
              );
            })}
          </div>

          {/* Legend */}
          <div className="flex flex-wrap gap-4 mt-5 pt-4 border-t border-[#e2e8f0]">
            {Object.entries(STATUS_COLORS).map(([key, val]) => (
              <div key={key} className="flex items-center gap-2">
                <div className={`w-3 h-3 rounded-full ${val.bg}`} />
                <span className="text-xs text-[#5a6577]">{val.label}</span>
              </div>
            ))}
            <div className="flex items-center gap-2">
              <div className="w-3 h-3 rounded-full bg-gray-100" />
              <span className="text-xs text-[#5a6577]">Weekend / No Data</span>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Info about excused days */}
      {excusedCount > 0 && (
        <Card>
          <CardContent className="p-4">
            <p className="text-sm text-[#5a6577]">
              <ShieldCheck className="w-4 h-4 inline mr-1.5 text-[#3B82F6]" />
              {excusedCount} excused {excusedCount === 1 ? 'day' : 'days'} this month (counted separately from absences).
            </p>
          </CardContent>
        </Card>
      )}
    </div>
  );
}
