"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { cn } from "@/lib/utils";
import type { UserRole } from "@/types";
import {
  LayoutDashboard,
  GraduationCap,
  MessageSquare,
  Users,
  Brain,
  Calendar,
  FileText,
  Shield,
  UserCircle,
  BarChart3,
  Sparkles,
} from "lucide-react";

interface MobileNavItem {
  label: string;
  href: string;
  icon: React.ElementType;
}

const mobileNavByRole: Record<UserRole, MobileNavItem[]> = {
  student: [
    { label: "Home", href: "/dashboard/student", icon: LayoutDashboard },
    { label: "AI Tutor", href: "/ai-tutor", icon: Brain },
    { label: "Grades", href: "/grades", icon: GraduationCap },
    { label: "Profile", href: "/profile", icon: UserCircle },
  ],
  parent: [
    { label: "Home", href: "/parent/dashboard", icon: LayoutDashboard },
    { label: "Attendance", href: "/parent/attendance", icon: Calendar },
    { label: "Grades", href: "/parent/grades", icon: GraduationCap },
    { label: "Messages", href: "/parent/messages", icon: MessageSquare },
    { label: "Profile", href: "/parent/profile", icon: UserCircle },
  ],
  teacher: [
    { label: "Home", href: "/teacher", icon: LayoutDashboard },
    { label: "Attendance", href: "/teacher/attendance", icon: Calendar },
    { label: "Grades", href: "/teacher/grades", icon: GraduationCap },
    { label: "Messages", href: "/teacher/messages", icon: MessageSquare },
    { label: "Analytics", href: "/teacher/analytics", icon: BarChart3 },
  ],
  facilitator: [
    { label: "Home", href: "/facilitator/dashboard", icon: LayoutDashboard },
    { label: "Attendance", href: "/facilitator/attendance", icon: Calendar },
    { label: "Grades", href: "/facilitator/grades", icon: GraduationCap },
    { label: "Messages", href: "/facilitator/messages", icon: MessageSquare },
  ],
  admin: [
    { label: "Home", href: "/admin", icon: LayoutDashboard },
    { label: "Users", href: "/admin/users", icon: Users },
    { label: "Students", href: "/admin/students", icon: GraduationCap },
    { label: "AI Budget", href: "/admin/ai-budget", icon: Sparkles },
  ],
};

interface MobileNavProps {
  role: UserRole;
}

export function MobileNav({ role }: MobileNavProps) {
  const pathname = usePathname();
  const navItems = mobileNavByRole[role];

  return (
    <nav className="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-[#e2e8f0] md:hidden">
      <div className="flex items-center justify-around px-2 py-2">
        {navItems.map((item) => {
          const isActive =
            pathname === item.href ||
            (item.href !== `/dashboard/${role}` &&
              pathname.startsWith(item.href));

          return (
            <Link
              key={item.href}
              href={item.href}
              className={cn(
                "flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-lg min-w-[56px] transition-colors duration-200",
                isActive
                  ? "text-[#FFD100]"
                  : "text-[#5a6577] hover:text-[#003087]"
              )}
            >
              <item.icon
                className={cn(
                  "h-5 w-5",
                  isActive && "stroke-[2.5]"
                )}
              />
              <span
                className={cn(
                  "text-[10px] font-medium leading-tight",
                  isActive && "font-semibold"
                )}
              >
                {item.label}
              </span>
            </Link>
          );
        })}
      </div>
    </nav>
  );
}
