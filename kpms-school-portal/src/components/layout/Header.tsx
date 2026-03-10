"use client";

import { Bell } from "lucide-react";
import { getInitials } from "@/lib/utils";

interface HeaderProps {
  pageTitle: string;
  userName: string;
}

export function Header({ pageTitle, userName }: HeaderProps) {
  const initials = getInitials(userName);

  return (
    <header className="sticky top-0 z-20 bg-white border-b border-[#e2e8f0] px-4 md:px-6 h-16 flex items-center justify-between">
      {/* Page Title */}
      <h2 className="font-heading font-semibold text-lg text-[#1a1a2e]">
        {pageTitle}
      </h2>

      {/* Right side: notifications + user */}
      <div className="flex items-center gap-4">
        {/* Notification bell */}
        <button
          className="relative p-2 rounded-xl hover:bg-[#F5F7FB] transition-colors duration-200 cursor-pointer"
          aria-label="Notifications"
        >
          <Bell className="h-5 w-5 text-[#5a6577]" />
          <span className="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-[#E8443A]" />
        </button>

        {/* User avatar + name */}
        <div className="flex items-center gap-3">
          <span className="hidden sm:block text-sm font-medium text-[#1a1a2e]">
            {userName}
          </span>
          <div className="flex h-9 w-9 items-center justify-center rounded-full bg-[#003087] text-white text-sm font-semibold">
            {initials}
          </div>
        </div>
      </div>
    </header>
  );
}
