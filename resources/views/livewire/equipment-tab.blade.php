<div class="flex flex-col h-full gap-4 p-8"
    x-data="{isFilterOpen: false, add_equipment_open: @entangle('add_equipment_open').defer}">
    <livewire:add-equipment />
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

            <div x-show="isFilterOpen" class="absolute z-10 mt-2 border-2 border-blue-500 rounded-md bg-zinc-50"
                x-cloak>
                <form wire:submit.prevent="filterTable" class="flex flex-col p-4 min-w-80">

                    <!-- employee -->
                    <div x-data="{ searchEmployee: '', selectedEmployee: '', personFilter: '', showDropdown: false }"
                        @clear-employee-filter.window="selectedEmployee = ''; personFilter = ''; $wire.set('personFilter', '');">
                        <label for="personFilter" class="text-sm">Person Accountable</label>

                        <!-- Custom Select -->
                        <div class="relative">
                            <div @click="showDropdown = !showDropdown"
                                class="w-full p-2 text-sm bg-white border-2 rounded-md cursor-pointer border-zinc-200">
                                <span x-text="selectedEmployee ? selectedEmployee : 'Select Employee'"></span>
                            </div>

                            <!-- Dropdown -->
                            <div x-show="showDropdown" @click.away="showDropdown = false"
                                class="absolute z-10 w-full mt-1 overflow-auto bg-white border border-gray-200 rounded-md shadow-md max-h-40">

                                <!--  ADDED: Search Input -->
                                <input type="text" x-model="searchEmployee" placeholder="Search Employee..."
                                    class="w-full p-2 text-sm border-b border-gray-200">

                                <!--  ADDED: Filtered Options -->
                                <template
                                    x-for="employee in {{ json_encode($employees) }}.filter(e => e.lastname.toLowerCase().includes(searchEmployee.toLowerCase()) || e.firstname.toLowerCase().includes(searchEmployee.toLowerCase()))"
                                    :key="employee . employee_id">
                                    <div @click="
                                    selectedEmployee = `${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`;
                                    personFilter = employee.employee_id;
                                    showDropdown = false;
                                    $wire.set('personFilter', employee.employee_id);
                                " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                        <span
                                            x-text="`${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!--  ADDED: Hidden Input to Sync Livewire -->
                        <input type="hidden" x-model.defer="personFilter" wire:model.defer="personFilter">

                    </div>

                    <!-- location -->
                    <div x-data="{ searchLocation: '', selectedLocation: '', locationFilter: '', showDropdown: false }"
                        @clear-location-filter.window="selectedLocation = ''; locationFilter = ''; $wire.set('locationFilter', '');">
                        <label for="locationFilter" class="text-sm">Location</label>

                        <!-- Custom Select -->
                        <div class="relative">
                            <div @click="showDropdown = !showDropdown"
                                class="w-full p-2 text-sm bg-white border-2 rounded-md cursor-pointer border-zinc-200">
                                <span x-text="selectedLocation ? selectedLocation : 'Select Location'"></span>
                            </div>

                            <!-- Dropdown -->
                            <div x-show="showDropdown" @click.away="showDropdown = false"
                                class="absolute z-10 w-full mt-1 overflow-auto bg-white border border-gray-200 rounded-md shadow-md max-h-40">

                                <!--  ADDED: Search Input -->
                                <input type="text" x-model="searchLocation" placeholder="Search Location..."
                                    class="w-full p-2 text-sm border-b border-gray-200">

                                <!--  ADDED: Filtered Options -->
                                <template
                                    x-for="location in {{ json_encode($locations) }}.filter(e => e.description.toLowerCase().includes(searchLocation.toLowerCase()))"
                                    :key="location . location_id">
                                    <div @click="
                                                selectedLocation = `${location.description}`;
                                                locationFilter = location.location_id;
                                                showDropdown = false;
                                                $wire.set('locationFilter', location.location_id);
                                            " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                        <span x-text="`${location.description}`"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!--  ADDED: Hidden Input to Sync Livewire -->
                        <input type="hidden" x-model.defer="locationFilter" wire:model.defer="locationFilter">
                    </div>

                    <div>
                        <label for="acquired_date" class="text-sm">Acquired Date</label>
                        <x-bladewind::input type="date" size="small" add_clearing="false" wire:model="dateFilter"
                            id="acquired_date" />
                    </div>
                    <!-- 
                    <x-bladewind::button size="small" can_submit="true" class="w-full mt-2"
                        x-on:click="isFilterOpen = false">Filter</x-bladewind::button> -->
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
            <option value="section_division">Section/Division</option>
            <option value="location_description">Location</option>
            <option value="remarks">Remarks</option>
        </select>

        <x-bladewind::button button_text_css="font-bold" size="small"
            wire:click="clearSearchString()">Refresh</x-bladewind::button>
        @if (Auth::user()->role == 1)
            <x-bladewind::button button_text_css="font-bold flex items-center gap-2" size="small"
                x-on:click="add_equipment_open = true">
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
                        'text-blue-500 font-bold' => $orderByString == 'section_division'
                    ])>SECTION/DIVISION
                    </div>
                </th>

                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'location_description'
                    ])>LOCATION
                    </div>
                </th>

                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'equipment_id'
                    ])>ACQUIRED DATE</div>
                </th>

                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'remarks'
                    ])>REMARKS</div>
                </th>
                <th></th>
                <th></th>
                @if (Auth::user()->role == 1)
                    <th></th>
                @endif
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
                        {{ $equipment->section_division }}

                    </td>

                    <td>
                        {{ $equipment->location_description }}
                    </td>

                    <td>
                        @if ($equipment->acquired_date)
                            {{ $equipment->acquired_date }}
                        @else
                            Unknown
                        @endif
                    </td>

                    <td>
                        {{ $equipment->remarks }}
                    </td>

                    <td>
                        <div class="flex justify-center w-full" x-data="{isHistoryOpen: false}">
                            <button x-on:click="isHistoryOpen = true">
                                <x-bladewind::icon name="clock" class="text-blue-900" />
                            </button>
                            <div x-show="isHistoryOpen" x-cloak>
                                <livewire:equipment-history equipmentId="{{ $equipment->equipment_id }}"
                                    wire:key="equipment-history-{{ $equipment->equipment_id }}" />
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="flex justify-center w-full" x-data="{isTransferOpen: false}">
                            <button x-on:click="isTransferOpen = true">
                                <x-bladewind::icon name="arrow-uturn-right" class="text-blue-900" />
                            </button>
                            <div x-show="isTransferOpen" x-cloak>
                                <livewire:transfer-equipment equipmentId="{{ $equipment->equipment_id }}"
                                    wire:key="equipment-transfer-{{ $equipment->equipment_id }}" />
                            </div>
                        </div>
                    </td>
                    @if (Auth::user()->role == 1)

                        <td>
                            <button wire:click="editItem({{ $equipment->equipment_id }})">
                                <x-bladewind::icon name="wrench-screwdriver" class="text-blue-900" />
                            </button>
                        </td>
                    @endif
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
                    <option value="equipment_id">Acquired Date</option>
                    <option value="section_division">Section/Division</option>
                    <option value="location_description">Location</option>
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
            @if (count($equipments))
                <x-bladewind::button class="ml-auto" color="green" button_text_css="font-bold"
                    wire:click="downloadTable">download</x-bladewind::button>
            @endif
            <!-- download -->
        </div>
    </div>
    <!-- links page -->
</div>