<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($racks as $r)
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xl">🗄️</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $r->status === 'OCCUPIED' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' }}">{{ $r->status }}</span>
        </div>
        <h3 class="font-bold text-sm text-gray-900 dark:text-white">{{ $r->name }}</h3>
        <p class="text-xs text-gray-500 mt-1">{{ $r->customer->name ?? 'Unassigned' }}</p>
        <div class="flex gap-2 mt-2 text-[10px] text-gray-400">
            <span>{{ $r->type }}</span><span>·</span><span>{{ $r->u_capacity }}U</span>
            <span>·</span><span>{{ $r->row->dataHall->floor->datacenter->name ?? '-' }}</span>
        </div>
    </div>
    @empty
    <div class="col-span-full flex items-center justify-center py-16 text-gray-400">📦 No colocation racks found</div>
    @endforelse
</div>
