<div>
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="size-16 flex items-center justify-center rounded-2xl bg-violet-100 dark:bg-violet-900/30 text-violet-600 mb-4">
            @svg('heroicon-o-users', 'size-8')
        </div>
        <h2 class="text-lg font-bold">{{ \DB::table('users')->whereNotNull('customer_id')->count() }} Client Accounts</h2>
        <p class="text-sm text-gray-500 mt-2">Manage in <a href="/admin/users" class="text-primary underline">Users</a></p>
    </div>
</div>
