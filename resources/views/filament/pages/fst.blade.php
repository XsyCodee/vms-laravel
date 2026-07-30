<div>
    <div class="flex justify-between items-center mb-4">
        <div><h2 class="text-lg font-bold text-gray-900 dark:text-white">Form Serah Terima</h2><p class="text-sm text-gray-500">{{ $records->count() }} records</p></div>
    </div>
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Item Name</th><th class="px-4 py-3">Rack</th><th class="px-4 py-3">SN</th><th class="px-4 py-3">Qty</th><th class="px-4 py-3">Dim</th><th class="px-4 py-3">Active</th><th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($records as $r)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="px-4 py-3 font-medium">{{ $r->item_name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $r->rack_name }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $r->serial_number }}</td>
                    <td class="px-4 py-3">{{ $r->qty }}</td>
                    <td class="px-4 py-3 text-xs">{{ $r->dimension }}</td>
                    <td class="px-4 py-3"><span class="{{ $r->is_active ? 'text-emerald-600' : 'text-red-500' }} font-bold text-xs">{{ $r->is_active ? '✓' : '✗' }}</span></td>
                    <td class="px-4 py-3 text-xs text-gray-400">{{ $r->arrival_date ? \Carbon\Carbon::parse($r->arrival_date)->format('d M Y') : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">No FST records found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
