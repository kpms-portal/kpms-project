import * as React from 'react';
import { cn } from '@/lib/utils';

interface BadgeProps extends React.HTMLAttributes<HTMLSpanElement> {
  variant?: 'default' | 'secondary' | 'destructive' | 'outline' | 'success' | 'warning';
}

const variantClasses: Record<string, string> = {
  default: 'bg-[#003087] text-white',
  secondary: 'bg-[#F5F7FB] text-[#5a6577]',
  destructive: 'bg-[#E8443A] text-white',
  outline: 'border border-[#e2e8f0] text-[#5a6577]',
  success: 'bg-[#0A8F6C] text-white',
  warning: 'bg-[#F59E0B] text-white',
};

export function Badge({ className, variant = 'default', ...props }: BadgeProps) {
  return (
    <span
      className={cn(
        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
        variantClasses[variant],
        className
      )}
      {...props}
    />
  );
}
