<div class="flex flex-col h-full gap-4 p-8" x-data="{isFilterOpen: false}">
    <!-- loading element -->
    <div wire:loading class="absolute top-0 left-0 z-50 bg-zinc-900/30 size-full">
        <div class="flex items-center justify-center h-full">
            <x-bladewind::spinner size="omg" color="blue" />
        </div>
    </div>
    <!-- loading element -->

    <!-- Search -->
    <div class="flex items-center gap-4">
        <!-- Filter -->
        <div class="relative">
            <button x-on:click="isFilterOpen = ! isFilterOpen">
                <x-bladewind::icon name="adjustments-horizontal" class="!stroke-blue-600" />
            </button>

            <div x-show="isFilterOpen" class="absolute z-10 mt-2 border-2 border-blue-500 rounded-md bg-zinc-50">
                <form wire:submit.prevent="filterTable" class="flex flex-col p-4 min-w-80">
                    <div class="flex flex-col">
                        <label for="employee_id" class="text-sm">Person Accountable</label>
                        <select id="employee_id" wire:model.defer="personFilter"
                            class="p-2 text-sm border-2 rounded-md border-zinc-200">
                            <option value="">Select person accountable</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee['employee_id'] }}">{{ strtoupper($employee['lastname']) }},
                                    {{ strtoupper($employee['firstname']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="unit_id" class="text-sm">Current Location</label>
                        <select id="unit_id" wire:model.defer="locationFilter"
                            class="p-2 text-sm border-2 rounded-md border-zinc-200">
                            <option value="">Select current location</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit['unit_id'] }}">
                                    {{ $unit['unit_desc'] }}({{ $unit['unit_code'] }})[{{ $unit['division_code'] }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="acquired_date" class="text-sm">Acquired Date</label>
                        <x-bladewind::input type="date" size="small" add_clearing="false" wire:model.defer="dateFilter"
                            id="acquired_date" />
                    </div>

                    <x-bladewind::button size="small" can_submit="true" class="w-full mt-2">Save</x-bladewind::button>
                </form>
            </div>
        </div>
        <!-- Filter -->
        <form wire:submit.prevent="searchFilter" class="grow">
            <x-bladewind::input focused placeholder="Search..." wire:model.defer="searchString" add_clearing="false"
                size="regular" />
        </form>
        <select class="px-4 py-1 rounded-md w-44 min-w-48" wire:model="searchBy">
            <option value="equipment_name">Equipment type</option>
            <option value="brand">Brand</option>
            <option value="model">Model</option>
            <option value="serial_number">Serial number</option>
            <option value="mr_no">MR NO</option>
            <option value="lastname">Person accountable
            </option>
            <option value="acquired_date">Acquired Date</option>
            <option value="unit_desc">Current location</option>
            <option value="remarks">Remarks</option>
        </select>

        <x-bladewind::button button_text_css="font-bold" size="small"
            wire:click="clearSearchString()">Refresh</x-bladewind::button>
        @if (Auth::user()->role == 1)
            <x-bladewind::button button_text_css="font-bold flex items-center gap-2" size="small" wire:click="addItem()">
                <x-bladewind::icon name="plus" type="solid" class="!w-4 !h-4" />
                Add New Item</x-bladewind::button>
        @endif
    </div>
    <!-- Search -->
    <!-- table -->
    <div class="overflow-y-auto grow font-jetbrains table-container">
        <x-bladewind::table has_border="true" divider="thin" celled="true">
            <x-slot name="header">
                <th>
                    <div>#</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'equipment_name'
                    ])>EQUIPMENT TYPE</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'brand'
                    ])>BRAND</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'model'
                    ])>MODEL</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'serial_number'
                    ])>SERIAL NUMBER</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'mr_no'
                    ])>MR NO</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'name'
                    ])>PERSON ACCOUNTABLE
                    </div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'equipment_id'
                    ])>ACQUIRED DATE</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'unit_desc'
                    ])>CURRENT LOCATION
                    </div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'remarks'
                    ])>REMARKS</div>
                </th>
                <th></th>
                <th></th>
                <th></th>
            </x-slot>
            @foreach ($equipments as $equipment)
                <tr>
                    <td>{{$loop->index + 1 + (($equipments->currentPage() - 1) * $itemPerPage)}} </td>

                    <td>
                        {{ $equipment->equipment_name }}
                    </td>

                    <td>
                        {{ $equipment->brand }}
                    </td>

                    <td>
                        {{ $equipment->model }}
                    </td>

                    <td>
                        {{ $equipment->serial_number }}
                    </td>

                    <td>
                        {{ $equipment->mr_no }}
                    </td>

                    <td>
                        {{ $equipment->name }}
                    </td>

                    <td>
                        {{ $equipment->acquired_date }}
                    </td>

                    <td>
                        {{ $equipment->unit_desc }}({{ $equipment->unit_code }})[{{ $equipment->division_code }}]
                    </td>

                    <td>
                        {{ $equipment->remarks }}
                    </td>

                    <td>
                        <div class="flex justify-center w-full">
                            <button wire:click="openEquipmentHistory({{ $equipment->equipment_id }})">
                                <x-bladewind::icon name="clock" class="text-blue-900" />
                            </button>
                        </div>
                    </td>

                    <td>
                        <div class="flex justify-center w-full">
                            <button wire:click="transferEquipment({{ $equipment->equipment_id }})">
                                <x-bladewind::icon name="arrow-uturn-right" class="text-blue-900" />
                            </button>
                        </div>
                    </td>

                    <td>
                        @if (Auth::user()->role == 1)
                            <button wire:click="editItem({{ $equipment->equipment_id }})">
                                <x-bladewind::icon name="wrench-screwdriver" class="text-blue-900" />
                            </button>
                        @endif
                    </td>
            @endforeach
        </x-bladewind::table>

        <!-- no data message -->
        @if (!count($equipments))
            <div class="mt-4">
                <x-bladewind::empty-state image="/images/no-data.svg" message="No data found."></x-bladewind::empty-state>
            </div>
        @endif
        <!-- no data message -->
    </div>
    <!-- table -->
    <!-- links page -->
    <div>
        {{ $equipments->onEachSide(1)->links() }}
        <div class="flex items-center gap-2 mt-4 text-sm">
            <p class="">Page: <span class="font-bold">{{ $equipments->currentPage() }}</span></p>
            <p>Total equipments: <span class="font-bold">{{ $totalEquipments }}</span></p>
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
                <select class="w-40 px-2" wire:model="orderByString">
                    <option value="equipment_name">Equipment type</option>
                    <option value="brand">Brand</option>
                    <option value="model">Model</option>
                    <option value="serial_number">Serial number</option>
                    <option value="mr_no">MR NO</option>
                    <option value="name">Person accountable</option>
                    <option value="acquired_date">Acquired Date</option>
                    <option value="unit_desc">Current location</option>
                    <option value="remarks">Remarks</option>
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
            <!-- download -->
            <x-bladewind::button class="ml-auto" color="green"
                button_text_css="font-bold" wire:click="downloadTable">download</x-bladewind::button>
            <!-- download -->
        </div>
    </div>
    <!-- links page -->
</div>