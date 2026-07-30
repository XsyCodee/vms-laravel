<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 h-[70vh]">
    {{-- Left: Email list --}}
    <div class="lg:col-span-1 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 overflow-y-auto">
        <div class="p-3 border-b border-gray-200 dark:border-gray-700 font-semibold text-sm text-gray-900 dark:text-white">Inbox ({{ $emails->count() }})</div>
        @forelse($emails as $e)
        <a href="?id={{ $e->id }}" class="block p-3 border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors {{ request('id')==$e->id ? 'bg-violet-50 dark:bg-violet-900/20 border-l-2 border-l-violet-600' : '' }}">
            <p class="text-[13px] font-semibold text-gray-900 dark:text-white truncate">{{ $e->from }}</p>
            <p class="text-[12px] font-medium text-gray-700 dark:text-gray-300 truncate mt-0.5">{{ $e->subject }}</p>
            <p class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($e->received_at)->diffForHumans() }}</p>
        </a>
        @empty
        <div class="flex items-center justify-center py-16 text-gray-400">📭 No messages</div>
        @endforelse
    </div>
    {{-- Right: Detail --}}
    <div class="lg:col-span-2 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 p-6 overflow-y-auto">
        @if($selected)
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $selected->subject }}</h2>
            <p class="text-[13px] text-gray-500 mt-1"><strong>From:</strong> {{ $selected->from }} &middot; {{ \Carbon\Carbon::parse($selected->received_at)->format('d M Y H:i') }}</p>
            <div class="mt-4 text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $selected->body_text }}</div>
        @else
            <div class="flex flex-col items-center justify-center h-full text-gray-400">📧<p class="mt-2 text-sm">Select a message to read</p></div>
        @endif
    </div>
</div>
