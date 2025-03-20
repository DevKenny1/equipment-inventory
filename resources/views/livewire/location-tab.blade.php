<div class="flex flex-col h-full gap-4 p-8" x-data="{add_location_open: @entangle('add_location_open').defer }">
    <livewire:add-location />
    <!-- loading element -->
    <div wire:loading class="absolute top-0 left-0 z-50 bg-zinc-900/30 size-full">
        <div class="flex items-center justify-center h-full">
            <x-bladewind::spinner size="omg" color="blue" />
        </div>
    </div>
    <!-- loading element -->

    <!-- Search -->
    <div class="flex items-center gap-4">
        <form wire:submit.prevent="searchFilter" class="grow">
            <x-bladewind::input focused placeholder="Search..." wire:model.defer="searchString" add_clearing="false"
                size="regular" />
        </form>
        <select class="px-4 py-1 rounded-md w-44 min-w-32" wire:model="searchBy">
            <option value="description">Description</option>
        </select>
        <x-bladewind::button button_text_css="font-bold" size="small"
            wire:click="clearSearchString()">Refresh</x-bladewind::button>
        @if (Auth::user()->role == 1)
            <x-bladewind::button button_text_css="font-bold flex items-center gap-2" size="small"
                x-on:click="add_location_open = true">
                <x-bladewind::icon name="plus" type="solid" class="!w-4 !h-4" />
                Add New Location</x-bladewind::button>
        @endif
    </div>
    <!-- Search -->

    <!-- table -->
    <div class="overflow-y-auto grow font-jetbrains table-container">
        <x-bladewind::table has_border="true" divider="thin" celled="true">
            <x-slot name="header">
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'location_id'
                    ])>#</div>
                </th>

                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'description'
                    ])>DESCRIPTION</div>
                </th>

                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'status'
                    ])> STATUS</div>
                </th>

                @if (Auth::user()->role == 1)
                    <th></th>
                @endif
            </x-slot>
            @foreach ($locations as $location)
                <tr>
                    <td>{{$loop->index + 1 + (($locations->currentPage() - 1) * $itemPerPage)}} </td>
                    <td>
                        {{ $location->description }}
                    </td>

                    <td>
                        @if ($location->status == '1')
                            <x-bladewind::tag label="available" color="green" />
                        @elseif($location->status == '0')
                            <x-bladewind::tag label="unavailable" color="red" />
                        @endif
                    </td>

                    @if (Auth::user()->role == 1)
                        <td>
                            <button wire:click="openEditLocation({{ $location->location_id }})">
                                <x-bladewind::icon name="wrench-screwdriver" class="text-blue-900" />
                            </button>
                        </td>
                    @endif
            @endforeach
        </x-bladewind::table>

        <!-- no data message -->
        @if (!count($locations))
            <div class="mt-4">
                <x-bladewind::empty-state image="/images/no-data.svg" message="No data found."></x-bladewind::empty-state>
            </div>
        @endif
        <!-- no data message -->
    </div>
    <!-- table -->

    <!-- links page -->
    <div>
        {{ $locations->onEachSide(1)->links() }}
        <div class="flex items-center gap-2 mt-4 text-sm">
            <p class="">Page: <span class="font-bold">{{ $locations->currentPage() }}</span></p>
            <p>Total locations: <span class="font-bold">{{ $totalLocations}}</span></p>
            <!-- items per page -->
            <div>
                Items per page:
                <select class="w-16 px-2" wire:model="itemPerPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                </select>
            </div>
            <!-- items per page -->
            <!-- sort by -->
            <div>
                Sort by:
                <select class="px-2 w-36" wire:model="orderByString">
                    <option value="location_id">Date Added</option>
                    <option value="description">Description</option>
                    <option value="status">Status</option>

                </select>
            </div>
            <!-- sort by -->
            <!-- sort order -->
            <div>
                Sort order:
                <select class="px-2 w-28" wire:model="orderBySort">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <!-- sort order -->
        </div>
    </div>
    <!-- links page -->
</div>