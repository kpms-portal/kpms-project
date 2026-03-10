import * as React from 'react';
import { Inbox } from 'lucide-react';
import type { LucideIcon } from 'lucide-react';

interface EmptyStateProps {
  icon?: React.ReactNode | LucideIcon;
  title?: string;
  description?: string;
  message?: string;
}

export function EmptyState({
  icon,
  title = 'No data yet',
  description,
  message,
}: EmptyStateProps) {
  const desc = description || message || 'There is nothing to show here.';

  const renderIcon = () => {
    if (!icon) return <Inbox className="h-12 w-12" />;
    if (typeof icon === 'function') {
      const IconComponent = icon as LucideIcon;
      return <IconComponent className="h-12 w-12" />;
    }
    return icon;
  };

  return (
    <div className="flex flex-col items-center justify-center py-12 text-center">
      <div className="text-[#5a6577]/40 mb-4">{renderIcon()}</div>
      <h3 className="text-lg font-semibold text-[#1a1a2e] mb-1">{title}</h3>
      <p className="text-sm text-[#5a6577] max-w-sm">{desc}</p>
    </div>
  );
}
