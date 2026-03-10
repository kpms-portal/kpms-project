"use client";

import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { createClient } from "@/lib/supabase/client";
import { cn } from "@/lib/utils";
import type { UserRole } from "@/types";
import {
  LayoutDashboard,
  GraduationCap,
  MessageSquare,
  Users,
  BarChart3,
  LogOut,
  Brain,
  Calendar,
  FileText,
  Shield,
  UserCircle,
  Sparkles,
  School,
  Megaphone,
  Settings,
} from "lucide-react";

interface NavItem {
  label: string;
  href: string;
  icon: React.ElementType;
}

const navByRole: Record<UserRole, NavItem[]> = {
  student: [
    { label: "Dashboard", href: "/dashboard/student", icon: LayoutDashboard },
    { label: "AI Tutor", href: "/ai-tutor", icon: Brain },
    { label: "Grades", href: "/grades", icon: GraduationCap },
    { label: "Profile", href: "/profile", icon: UserCircle },
  ],
  parent: [
    { label: "Dashboard", href: "/parent/dashboard", icon: LayoutDashboard },
    { label: "Attendance", href: "/parent/attendance", icon: Calendar },
    { label: "Grades", href: "/parent/grades", icon: GraduationCap },
    { label: "Messages", href: "/parent/messages", icon: MessageSquare },
    { label: "Announcements", href: "/parent/announcements", icon: Megaphone },
    { label: "Child Profile", href: "/parent/profile", icon: UserCircle },
  ],
  teacher: [
    { label: "Dashboard", href: "/teacher", icon: LayoutDashboard },
    { label: "Attendance", href: "/teacher/attendance", icon: Calendar },
    { label: "Grades", href: "/teacher/grades", icon: GraduationCap },
    { label: "Messages", href: "/teacher/messages", icon: MessageSquare },
    { label: "AI Analytics", href: "/teacher/analytics", icon: BarChart3 },
  ],
  facilitator: [
    { label: "Dashboard", href: "/facilitator/dashboard", icon: LayoutDashboard },
    { label: "Attendance", href: "/facilitator/attendance", icon: Calendar },
    { label: "Grades", href: "/facilitator/grades", icon: GraduationCap },
    { label: "Messages", href: "/facilitator/messages", icon: MessageSquare },
  ],
  admin: [
    { label: "Overview", href: "/admin", icon: LayoutDashboard },
    { label: "Dashboard", href: "/admin/dashboard", icon: BarChart3 },
    { label: "Users", href: "/admin/users", icon: Users },
    { label: "Students", href: "/admin/students", icon: GraduationCap },
    { label: "AI Budget", href: "/admin/ai-budget", icon: Sparkles },
    { label: "Classes", href: "/admin/classes", icon: School },
    { label: "Announcements", href: "/admin/announcements", icon: Megaphone },
    { label: "Settings", href: "/admin/settings", icon: Settings },
  ],
};

interface SidebarProps {
  role: UserRole;
}

export function Sidebar({ role }: SidebarProps) {
  const pathname = usePathname();
  const router = useRouter();
  const supabase = createClient();
  const navItems = navByRole[role];

  async function handleLogout() {
    await supabase.auth.signOut();
    router.push("/auth/login");
  }

  return (
    <aside className="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 bg-[#003087] text-white z-30">
      {/* Logo / Title */}
      <div className="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFD100]">
          <span className="text-[#003087] font-heading font-bold text-lg">K</span>
        </div>
        <div>
          <h1 className="font-heading font-bold text-lg leading-tight">KPMS</h1>
          <p className="text-xs text-white/60">School Portal</p>
        </div>
      </div>

      {/* Navigation */}
      <nav className="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        {navItems.map((item) => {
          const isOverviewRoute =
            item.href === "/admin" ||
            item.href === `/dashboard/${role}` ||
            item.href === `/${role}`;
          const isActive = isOverviewRoute
            ? pathname === item.href
            : pathname === item.href || pathname.startsWith(item.href + "/");

          return (
            <Link
              key={item.href}
              href={item.href}
              className={cn(
                "flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200",
                isActive
                  ? "bg-[#FFD100] text-[#003087] shadow-md"
                  : "text-white/80 hover:bg-white/10 hover:text-white"
              )}
            >
              <item.icon className="h-5 w-5 shrink-0" />
              <span>{item.label}</span>
            </Link>
          );
        })}
      </nav>

      {/* Logout */}
      <div className="px-3 py-4 border-t border-white/10">
        <button
          onClick={handleLogout}
          className="flex w-full items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-200 cursor-pointer"
        >
          <LogOut className="h-5 w-5 shrink-0" />
          <span>Log Out</span>
        </button>
      </div>
    </aside>
  );
}
