<div>
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="size-16 flex items-center justify-center rounded-2xl bg-violet-100 dark:bg-violet-900/30 text-violet-600 mb-4">
            @svg('heroicon-o-server', 'size-8')
        </div>
        <h2 class="text-lg font-bold">{{ \DB::table('rack_equipments')->whereNotNull('customer_id')->count() }} Client Devices</h2>
        <p class="text-sm text-gray-500 mt-2">View all in <a href="/admin/racks" class="text-primary underline">Data Rack</a></p>
    </div>
</div>
