<div class="space-y-4">
    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 text-center">
            <span class="text-3xl">🚶</span>
            <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Active Visitors</h3>
            <p class="text-2xl font-bold text-violet-600 mt-1">{{ $activeVisitors }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 text-center">
            <span class="text-3xl">📋</span>
            <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Today's Permits</h3>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $todayPermits }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 text-center">
            <span class="text-3xl">🔴</span>
            <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Security Status</h3>
            <div class="flex items-center justify-center gap-1.5 mt-1">
                <div class="size-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-sm font-bold text-emerald-600">Online</span>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 font-semibold text-sm text-gray-900 dark:text-white">Recent Activity Log</div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800 max-h-[400px] overflow-y-auto">
            @forelse($recentLogs as $log)
            <div class="flex items-start gap-3 p-3">
                <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 text-sm">📋</div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold text-gray-900 dark:text-white truncate">{{ $log->resource ?? 'System' }}</p>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $log->action }} &middot; {{ $log->details ?? '-' }}</p>
                </div>
                <span class="text-[10px] text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</span>
            </div>
            @empty
            <div class="flex justify-center py-12 text-gray-400">🔒 No security events</div>
            @endforelse
        </div>
    </div>
</div>
