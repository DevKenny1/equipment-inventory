<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
        <div class="p-6 rounded-lg bg-zinc-50 w-96">

            <h2 class="mb-4 text-xl font-bold text-center">Transfer Equipment</h2>
            <form wire:submit.prevent="transferEquipment">

                <div>
                    <label class="text-sm" for="equipment_name">Current Person Accountable</label>
                    <x-bladewind::input disabled="true" size="small" add_clearing="false" wire:model.defer="name"
                        id="equipment_name" />
                </div>

                <div>
                    <label class="text-sm" for="equipment_name">Current Location</label>
                    <x-bladewind::input disabled="true" size="small" add_clearing="false" wire:model.defer="location"
                        id="equipment_name" />
                </div>

                <div class="h-1 my-4 bg-gray-300"></div>

                <!-- employee -->
                <div x-data="{ searchEmployee: '', selectedEmployee: '', transfer_person: '', showDropdown: false }"
                    @clear-transfer-employee.window="selectedEmployee = ''; transfer_person = ''; $wire.set('transfer_person', '');">
                    <label for="transfer_person" class="text-sm">Person Accountable</label>

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
                                                        transfer_person = employee.employee_id;
                                                        showDropdown = false;
                                                        $wire.set('transfer_person', employee.employee_id);
                                                    " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                    <span
                                        x-text="`${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!--  ADDED: Hidden Input to Sync Livewire -->
                    <input type="hidden" x-model.defer="transfer_person" wire:model.defer="transfer_person">

                    @error('transfer_person')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- location -->
                <div x-data="{ searchLocation: '', selectedLocation: '', transfer_location: '', showDropdown: false }"
                    @clear-transfer-employee.window="selectedLocation = ''; transfer_location = ''; $wire.set('transfer_location', '');">
                    <label for="transfer_location" class="text-sm">Location</label>

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
                                <div @click="               selectedLocation = `${location.description}`;
                                                            transfer_location = location.location_id;
                                                            showDropdown = false;
                                                            $wire.set('transfer_location', location.location_id);
                                                        " class="p-2 text-sm cursor-pointer hover:bg-gray-100">
                                    <span x-text="`${location.description}`"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!--  ADDED: Hidden Input to Sync Livewire -->
                    <input type="hidden" x-model.defer="transfer_location" wire:model.defer="transfer_location">

                    @error('transfer_location')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <div class="flex gap-2 mt-2">

                    <x-bladewind::button x-on:click="open = false" wire:click="closeModal" class="w-full" color="red"
                        button_text_css="font-bold" size="small" outline="true">Cancel
                    </x-bladewind::button>

                    <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold"
                        size="small">Transfer
                    </x-bladewind::button>
                </div>
            </form>
        </div>
    </div>
</div>