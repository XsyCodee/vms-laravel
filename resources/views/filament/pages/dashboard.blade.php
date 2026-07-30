<div class="space-y-6">
    {{-- Sync Banner --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 rounded-xl border border-amber-200 dark:border-amber-800/50 bg-amber-50 dark:bg-amber-950/30 px-5 py-3.5">
        <div class="flex items-center gap-3">
            <div class="size-9 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600 shrink-0">
                @svg('heroicon-o-cog-6-tooth', 'size-4')
            </div>
            <div>
                <p class="text-[13px] font-semibold text-amber-900 dark:text-amber-100">Data Sync Required</p>
                <p class="text-[11px] text-amber-700 dark:text-amber-400">Orphan racks and missing accounts need resolution.</p>
            </div>
        </div>
        <a href="/admin/support-tickets" class="shrink-0 inline-flex items-center px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-[12px] font-semibold transition-colors">
            Resolve Issues
        </a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Regional Overview</h1>
            <p class="text-[13px] text-gray-500 dark:text-gray-400 mt-0.5">Infrastructure metrics for Jakarta Site (JKT-1)</p>
        </div>
        <a href="/admin/racks" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-violet-600 hover:bg-violet-700 text-white text-[12px] font-semibold shadow-sm transition-colors">
            @svg('heroicon-o-document-text', 'size-3.5') Generate Report
        </a>
    </div>

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $activeCount = \DB::table('visit_permits')->whereIn('status', ['CheckIn','Approved','NDASigned'])->count();
        $todayPermits = \DB::table('visit_permits')->where('created_at', '>=', now()->startOfDay())->count();
        $occupiedRacks = \DB::table('racks')->whereNotNull('customer_id')->count();
        $totalRacks = \DB::table('racks')->count();
        $cards = [
            ['name'=>'Active Permits', 'val'=>$activeCount, 'sub'=>"+{$todayPermits} today", 'href'=>url('/admin/visit-permits'), 'warn'=>false, 'icon'=>'users'],
            ['name'=>'Racks > 80%', 'val'=>$racksOver80, 'sub'=>$racksOver80>0?'Action required':"{$occupiedRacks}/{$totalRacks} occupied", 'href'=>url('/admin/racks'), 'warn'=>$racksOver80>0, 'icon'=>'server-stack'],
            ['name'=>'Interconnections', 'val'=>$activeIC, 'sub'=>"+{$weekIC} this week", 'href'=>url('/admin/interconnection-requests'), 'warn'=>false, 'icon'=>'arrows-right-left'],
            ['name'=>'Uptime', 'val'=>'100%', 'sub'=>'All nodes healthy', 'href'=>'#', 'warn'=>false, 'icon'=>'check-circle'],
        ];
        @endphp
        @foreach($cards as $c)
        <a href="{{$c['href']}}" class="group">
            <div class="rounded-xl border bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 p-5 transition-all hover:shadow-sm hover:border-violet-200 dark:hover:border-violet-700 {{$c['warn'] ? 'border-amber-200 dark:border-amber-700' : ''}}">
                <div class="flex items-start justify-between">
                    <div class="size-9 flex items-center justify-center rounded-lg shrink-0 {{$c['warn'] ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600' : 'bg-violet-50 dark:bg-violet-900/20 text-violet-600'}}">
                        @svg('heroicon-o-'.$c['icon'], 'size-[18px]')
                    </div>
                    @svg('heroicon-o-chevron-right', 'size-3.5 text-gray-300 dark:text-gray-600 group-hover:text-violet-500 transition-colors')
                </div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mt-4">{{$c['name']}}</p>
                <p class="text-2xl font-bold mt-0.5 tracking-tight text-gray-900 dark:text-white">{{$c['val']}}</p>
                <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-1.5">{{$c['sub']}}</p>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Bottom Row — 3 Columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Pending Permits --}}
        <div class="rounded-xl border bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden">
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="size-8 flex items-center justify-center rounded-lg bg-violet-50 dark:bg-violet-900/20 text-violet-600 shrink-0">
                        @svg('heroicon-o-users', 'size-[15px]')
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white">Pending Permits</h3>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-[10px] font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{$pending->count()}}</span>
            </div>
            <div class="flex-1 px-2 pb-2 space-y-0.5">
                @if($pending->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    @svg('heroicon-o-clock', 'size-8 text-gray-200 dark:text-gray-700 mb-2')
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">No Pending</p>
                </div>
                @else
                @foreach($pending as $p)
                <a href="/admin/visit-permits" class="block group">
                    <div class="flex items-center gap-3 rounded-lg p-2.5 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <div class="size-9 flex items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800 text-[11px] font-bold text-gray-500 dark:text-gray-400 shrink-0">
                            {{ strtoupper(substr($p->customer_name ?? '??', 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold leading-none truncate text-gray-900 dark:text-white">{{$p->customer_name ?? 'Unknown'}}</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">{{ \Carbon\Carbon::parse($p->scheduled_at)->format('M d, Y') }}</p>
                        </div>
                        @svg('heroicon-o-chevron-right', 'size-3.5 text-gray-300 dark:text-gray-600 group-hover:text-violet-500 transition-colors')
                    </div>
                </a>
                @endforeach
                @endif
            </div>
            <a href="/admin/visit-permits" class="block text-center py-3 bg-gray-50 dark:bg-gray-800 text-[11px] font-semibold text-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors uppercase tracking-wider">
                Manage All Permits
            </a>
        </div>

        {{-- Live Activity Feed --}}
        <div class="rounded-xl border bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden">
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="size-8 flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 shrink-0">
                        @svg('heroicon-o-qr-code', 'size-[15px]')
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white">Live Activity</h3>
                </div>
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-full">
                    <div class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Live</span>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-2 space-y-1" style="max-height:340px">
                @if($logs->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                    @svg('heroicon-o-exclamation-circle', 'size-10 text-gray-200 dark:text-gray-700 mb-3')
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">No Activity Recorded</p>
                </div>
                @else
                @foreach($logs as $log)
                <div class="group flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <div class="p-2 rounded-lg shrink-0 {{($log->action ?? '') === 'KIOSK_CHECKIN' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-600'}}">
                        @svg('heroicon-o-'.(($log->action ?? '') === 'KIOSK_CHECKIN' ? 'user-plus' : 'cube'), 'size-4')
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-tight">{{($log->action ?? '') === 'KIOSK_CHECKIN' ? 'Entry Logged' : 'Activity'}}</p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 font-bold">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</p>
                        </div>
                        <p class="text-[13px] font-bold text-gray-900 dark:text-white truncate">{{$log->resource ?? 'System'}}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 truncate">{{$log->details ?? '-'}}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <a href="/admin/visit-permits" class="p-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 text-center text-[11px] font-bold text-blue-600 hover:text-blue-500 transition-colors uppercase tracking-widest">
                View Full Security Audit
            </a>
        </div>

        {{-- Rack Capacity Donut --}}
        <div class="rounded-xl border bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 p-5 flex flex-col items-center">
            <div class="w-full flex items-center gap-2.5 mb-6">
                <div class="size-8 flex items-center justify-center rounded-lg bg-violet-50 dark:bg-violet-900/20 text-violet-600 shrink-0">
                    @svg('heroicon-o-archive-box', 'size-[15px]')
                </div>
                <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white">Rack Capacity</h3>
            </div>
            <div class="relative">
                <svg class="size-36 -rotate-90" viewBox="0 0 144 144">
                    <circle cx="72" cy="72" r="60" stroke="#E4E4E7" stroke-width="12" fill="transparent" class="dark:stroke-gray-700"/>
                    <circle cx="72" cy="72" r="60" stroke="#7C3AED" stroke-width="12" fill="transparent"
                        stroke-dasharray="377" stroke-dashoffset="{{377 - (377 * $pct) / 100}}"
                        stroke-linecap="round" class="transition-all duration-1000"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{$pct}}%</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Used</span>
                </div>
            </div>
            <div class="w-full mt-5 space-y-2">
                <div class="flex items-center justify-between rounded-lg bg-gray-50 dark:bg-gray-800 px-3 py-2">
                    <span class="text-[11px] font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                        <span class="size-2 rounded-full bg-violet-600"></span> Allocated
                    </span>
                    <span class="text-[13px] font-bold text-gray-900 dark:text-white">{{$totalUsedU}} U</span>
                </div>
                <div class="flex items-center justify-between rounded-lg bg-gray-50 dark:bg-gray-800 px-3 py-2">
                    <span class="text-[11px] font-medium text-gray-600 dark:text-gray-400 flex items-center gap-2">
                        <span class="size-2 rounded-full bg-gray-300 dark:bg-gray-600"></span> Free
                    </span>
                    <span class="text-[13px] font-bold text-gray-900 dark:text-white">{{$totalAvailableU - $totalUsedU}} U</span>
                </div>
            </div>
        </div>
    </div>
</div>
