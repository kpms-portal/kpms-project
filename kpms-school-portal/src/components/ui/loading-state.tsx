export function LoadingState({ message = 'Loading...' }: { message?: string }) {
  return (
    <div className="flex flex-col items-center justify-center py-12">
      <div className="h-8 w-8 animate-spin rounded-full border-4 border-[#e2e8f0] border-t-[#003087]" />
      <p className="mt-4 text-sm text-[#5a6577]">{message}</p>
    </div>
  );
}
