<div x-show="add_equipment_open" x-cloak
    class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
    <div class="p-6 rounded-lg bg-zinc-50 w-96">
        <h2 class="mb-4 text-xl font-bold text-center">Add Equipment</h2>
        <form wire:submit.prevent="createEquipment" class="flex flex-col gap-2">

            <!-- Equipment Type -->
            <div x-data="{ searchEquipmentType: '', selectedEquipmentType: '', equipment_type_id: '', showDropdown: false }"
                @clear-equipment-type.window="selectedEquipmentType = ''; equipment_type_id = ''; $wire.set('equipment_type_id', '');">

                <label for="equipment_type" class="text-sm">Equipment Type</label>

                <!-- Custom Select -->
                <div class="relative">
                    <div @click="showDropdown = !showDropdown"
                        class="w-full p-2 text-sm bg-white border-2 rounded-md cursor-pointer border-zinc-200">
                        <span x-text="selectedEquipmentType ? selectedEquipmentType : 'Select Equipment Type'"></span>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="showDropdown" @click.away="showDropdown = false"
                        class="absolute z-10 w-full mt-1 overflow-auto bg-white border border-gray-200 rounded-md shadow-md max-h-40">

                        <!-- Search Input -->
                        <input type="text" x-model="searchEquipmentType" placeholder="Search Equipment Type..."
                            class="w-full p-2 text-sm border-b border-gray-200">

                        <!-- Filtered Options -->
                        <template
                            x-for="equipment_type in {{ json_encode($equipment_types) }}.filter(e => e.equipment_name.toLowerCase().includes(searchEquipmentType.toLowerCase()))"
                            :key="equipment_type . equipment_type_id">
                            <div @click="
                        selectedEquipmentType = equipment_type.equipment_name;
                        equipment_type_id = equipment_type.equipment_type_id;
                        showDropdown = false;
                        $wire.set('equipment_type_id', equipment_type.equipment_type_id);
                    " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                <span x-text="equipment_type.equipment_name"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Hidden Input to Sync Livewire -->
                <input type="hidden" x-model.defer="equipment_type_id" wire:model.defer="equipment_type_id">

                @error('equipment_type_id')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label for="brand" class="text-sm">Brand</label>
                <x-bladewind::input placeholder="Enter brand" size="small" add_clearing="false" wire:model.defer="brand"
                    id="brand" />
                @error('brand') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="model" class="text-sm">Model</label>
                <x-bladewind::input placeholder="Enter model" size="small" add_clearing="false" wire:model.defer="model"
                    id="model" />
                @error('model') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="serial_number" class="text-sm">Serial Number</label>
                <x-bladewind::input placeholder="Enter serial number" size="small" add_clearing="false"
                    wire:model.defer="serial_number" id="serial_number" />
                @error('serial_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="mr_no" class="text-sm">MR NO</label>
                <x-bladewind::input placeholder="Enter mr no" size="small" add_clearing="false" wire:model.defer="mr_no"
                    id="mr_no" />
                @error('mr_no') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- employee -->
            <div x-data="{ searchEmployee: '', selectedEmployee: '', person_accountable_id: '', showDropdown: false }"
                @clear-employee.window="selectedEmployee = ''; person_accountable_id = ''; $wire.set('person_accountable_id', '');">
                <label for="person_accountable_id" class="text-sm">Person Accountable</label>

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
                                    person_accountable_id = employee.employee_id;
                                    showDropdown = false;
                                    $wire.set('person_accountable_id', employee.employee_id);
                                " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                <span
                                    x-text="`${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <!--  ADDED: Hidden Input to Sync Livewire -->
                <input type="hidden" x-model.defer="person_accountable_id" wire:model.defer="person_accountable_id">

                @error('person_accountable_id')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- location -->
            <div x-data="{ searchLocation: '', selectedLocation: '', location_id: '', showDropdown: false }"
                @clear-location.window="selectedLocation = ''; location_id = ''; $wire.set('location_id', '');">
                <label for="location_id" class="text-sm">Location</label>

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
                                                location_id = location.location_id;
                                                showDropdown = false;
                                                $wire.set('location_id', location.location_id);
                                            " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                <span x-text="`${location.description}`"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <!--  ADDED: Hidden Input to Sync Livewire -->
                <input type="hidden" x-model.defer="location_id" wire:model.defer="location_id">

                @error('location_id')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- acquired date -->
            <div>

                <label for="acquired_date" class="text-sm">Acquired Date</label>
                <x-bladewind::input type="date" size="small" add_clearing="false" wire:model.defer="acquired_date"
                    onkeydown="return false;" id=" acquired_date" />
                @error('acquired_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="remarks" class="text-sm">Remarks</label>
                <x-bladewind::textarea placeholder="Enter remarks" size="small" add_clearing="false"
                    wire:model.defer="remarks" id="remarks" class="resize-none" rows="3" />
                @error('remarks') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2 mt-2">

                <x-bladewind::button x-on:click="add_equipment_open = false" class="w-full" color="red"
                    button_text_css="font-bold" size="small" outline="true">Cancel
                </x-bladewind::button>

                <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold" size="small">Create
                </x-bladewind::button>
            </div>
        </form>
    </div>
</div>