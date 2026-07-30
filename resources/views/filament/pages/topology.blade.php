<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($datacenters as $dc)
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-2xl">🏢</span>
                <div><h3 class="font-bold text-gray-900 dark:text-white">{{ $dc->name }}</h3><p class="text-xs text-gray-500">{{ $dc->code }}</p></div>
            </div>
            @php $dcFloors = $floors->where('datacenter_id', $dc->id); @endphp
            @foreach($dcFloors as $floor)
            <div class="ml-4 mb-2 pl-3 border-l-2 border-gray-200 dark:border-gray-700">
                <p class="text-[13px] font-semibold text-gray-700 dark:text-gray-300">📂 {{ $floor->name }}</p>
                @php $floorHalls = $halls->where('floor_id', $floor->id); @endphp
                @foreach($floorHalls as $hall)
                <div class="ml-3 mt-1 text-xs text-gray-500">
                    <p>📊 {{ $hall->name }}</p>
                    @php $hallRows = $rows->where('room_id', $hall->id); @endphp
                    @foreach($hallRows as $row)
                    <span class="ml-2 inline-block px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-[10px]">{{ $row->name }}</span>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
