<div>
    <div class="flex justify-between items-center mb-4">
        <div><h2 class="text-lg font-bold text-gray-900 dark:text-white">Data Interkoneksi</h2><p class="text-sm text-gray-500">{{ $records->count() }} records</p></div>
    </div>
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Customer</th><th class="px-4 py-3">Rack A</th><th class="px-4 py-3">Device A</th><th class="px-4 py-3">Rack B</th><th class="px-4 py-3">Device B</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($records as $ic)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="px-4 py-3 font-medium">{{ $ic->customer_name }}</td>
                    <td class="px-4 py-3">{{ $ic->rack_a }}</td><td class="px-4 py-3">{{ $ic->device_a }}</td>
                    <td class="px-4 py-3">{{ $ic->rack_b }}</td><td class="px-4 py-3">{{ $ic->device_b }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $ic->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500' }}">{{ $ic->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-4 py-3 text-xs text-gray-400">{{ $ic->created_at ? \Carbon\Carbon::parse($ic->created_at)->format('d M Y') : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">No interconnection records found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
