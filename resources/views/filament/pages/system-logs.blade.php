<div class="space-y-4">
    {{-- Tabs --}}
    <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 rounded-lg p-1 w-fit">
        @foreach([
            'admin' => 'Admin Activity',
            'login' => 'Login Logs',
            'wablas' => 'Wablas API',
        ] as $key => $label)
        <a href="?tab={{ $key }}" class="px-4 py-2 rounded-md text-[13px] font-semibold transition-colors {{ $tab === $key ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
            {{ $label }} <span class="text-[10px] opacity-50">({{ $tabCounts[$key] ?? 0 }})</span>
        </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Timestamp</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Action</th>
                    <th class="px-4 py-3">Resource</th>
                    <th class="px-4 py-3">IP</th>
                    <th class="px-4 py-3">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($logs as $i => $log)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="px-4 py-2 text-gray-400 text-xs">{{ $log->id }}</td>
                    <td class="px-4 py-2 text-xs whitespace-nowrap">{{ $log->created_at }}</td>
                    <td class="px-4 py-2 text-xs font-medium">{{ $log->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold
                            {{ str_contains($log->action ?? '', 'LOGIN') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                            {{ str_contains($log->action ?? '', 'WABLAS') || str_contains($log->action ?? '', 'wa-notify') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}
                            {{ !str_contains($log->action ?? '', 'LOGIN') && !str_contains($log->action ?? '', 'WABLAS') && !str_contains($log->action ?? '', 'wa-notify') ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' : '' }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-xs text-gray-500">{{ $log->resource ?? '-' }}</td>
                    <td class="px-4 py-2 text-xs font-mono text-gray-400">{{ $log->ip_address ?? '-' }}</td>
                    <td class="px-4 py-2 text-xs text-gray-400 max-w-[250px] truncate">{{ $log->details ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">📋 No logs found for this filter</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
