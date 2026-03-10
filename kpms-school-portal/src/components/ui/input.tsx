import * as React from 'react';
import { cn } from '@/lib/utils';

export const Input = React.forwardRef<
  HTMLInputElement,
  React.InputHTMLAttributes<HTMLInputElement>
>(({ className, ...props }, ref) => {
  return (
    <input
      ref={ref}
      className={cn(
        'w-full px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#1a1a2e] text-sm placeholder-[#5a6577]/50 focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087] transition-all',
        className
      )}
      {...props}
    />
  );
});
Input.displayName = 'Input';
