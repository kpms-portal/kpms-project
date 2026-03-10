"use client";

import { Sidebar } from "./sidebar";
import { Header } from "./Header";
import { MobileNav } from "./mobile-nav";
import type { UserRole } from "@/types";

interface AppShellProps {
  children: React.ReactNode;
  role: UserRole;
  userName: string;
  pageTitle?: string;
}

export function AppShell({ children, role, userName, pageTitle = "Dashboard" }: AppShellProps) {
  return (
    <div className="flex min-h-screen bg-[#F5F7FB]">
      {/* Sidebar -- hidden on mobile, fixed on md+ */}
      <Sidebar role={role} />

      {/* Main content area -- offset by sidebar width on md+ */}
      <div className="flex-1 flex flex-col min-w-0 md:ml-64">
        {/* Header */}
        <Header pageTitle={pageTitle} userName={userName} />

        {/* Page content */}
        <main className="flex-1 p-4 md:p-6 pb-20 md:pb-6">
          {children}
        </main>

        {/* Mobile bottom navigation */}
        <MobileNav role={role} />
      </div>
    </div>
  );
}
