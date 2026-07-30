<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 text-center">
        <span class="text-3xl">👥</span>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Users</h3>
        <p class="text-2xl font-bold text-violet-600 mt-1">{{ $totalUsers }}</p>
        <a href="/admin/users" class="text-xs text-violet-600 font-semibold mt-2 inline-block">Manage →</a>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 text-center">
        <span class="text-3xl">🏢</span>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Customers</h3>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalCustomers }}</p>
        <a href="/admin/customers" class="text-xs text-blue-600 font-semibold mt-2 inline-block">Manage →</a>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 text-center">
        <span class="text-3xl">🗄️</span>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Racks</h3>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalRacks }}</p>
        <a href="/admin/racks" class="text-xs text-emerald-600 font-semibold mt-2 inline-block">Manage →</a>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 text-center">
        <span class="text-3xl">🖥️</span>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-white mt-2">Equipment</h3>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $totalEquipments }}</p>
        <a href="/admin/legacy-equipments" class="text-xs text-amber-600 font-semibold mt-2 inline-block">Manage →</a>
    </div>
</div>
