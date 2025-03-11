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

                <div class="flex flex-col">
                    <label for="employee_id" class="text-sm">Transfer Person Accountable</label>
                    <select id="employee_id" wire:model.defer="transfer_person"
                        class="p-2 text-sm border-2 rounded-md border-zinc-200">
                        <option value="">Select person accountable</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee['employee_id'] }}">{{ strtoupper($employee['lastname']) }},
                                {{ strtoupper($employee['firstname']) }}
                            </option>
                        @endforeach
                    </select>
                    @error('transfer_person') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div class="flex flex-col">
                    <label for="unit_id" class="text-sm">Transfer Location</label>
                    <select id="unit_id" wire:model.defer="transfer_location"
                        class="p-2 text-sm border-2 rounded-md border-zinc-200">
                        <option value="">Select current location</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit['unit_id'] }}">
                                {{ $unit['unit_desc'] }}({{ $unit['unit_code'] }})[{{ $unit['division_code'] }}]
                            </option>
                        @endforeach
                    </select>
                    @error('transfer_location') <small class="text-red-500">{{ $message }}</small> @enderror
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