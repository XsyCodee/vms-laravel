<div>
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        @php $clients = \DB::select("SELECT c.id, c.name, c.code, (SELECT COUNT(*) FROM racks WHERE customer_id=c.id) AS racks_count, (SELECT COUNT(*) FROM users WHERE customer_id=c.id) AS users_count, (SELECT COUNT(*) FROM visit_permits WHERE customer_id=c.id) AS permits_count FROM customers c ORDER BY c.name"); @endphp
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr><th class="px-4 py-3">Client</th><th class="px-4 py-3">Code</th><th class="px-4 py-3">Racks</th><th class="px-4 py-3">Users</th><th class="px-4 py-3">Permits</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($clients as $c)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="px-4 py-3 font-medium">{{ $c->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $c->code ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $c->racks_count }}</td>
                    <td class="px-4 py-3">{{ $c->users_count }}</td>
                    <td class="px-4 py-3">{{ $c->permits_count }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No clients found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
