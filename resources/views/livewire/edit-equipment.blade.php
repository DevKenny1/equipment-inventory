<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
        <div class="p-6 rounded-lg bg-zinc-50 w-96">
            <h2 class="mb-4 text-xl font-bold text-center">Edit Equipment</h2>
            <form wire:submit.prevent="editEquipment" class="flex flex-col gap-2">

                <div class="flex flex-col">
                    <label for="equipment_type" class="text-sm">Equipment Type</label>
                    <select id="equipment_type" wire:model.defer="equipment_type_id"
                        class="p-2 text-sm border-2 rounded-md border-zinc-200">
                        <option value="">Select equipment type</option>
                        @foreach ($equipment_types as $equipment_type)
                            <option value="{{ $equipment_type['equipment_type_id'] }}">
                                {{ $equipment_type['equipment_name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipment_type_id') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label for="brand" class="text-sm">Brand</label>
                    <x-bladewind::input placeholder="Enter brand" size="small" add_clearing="false"
                        wire:model.defer="brand" id="brand" />
                    @error('brand') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="model" class="text-sm">Model</label>
                    <x-bladewind::input placeholder="Enter model" size="small" add_clearing="false"
                        wire:model.defer="model" id="model" />
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
                    <x-bladewind::input placeholder="Enter mr no" size="small" add_clearing="false"
                        wire:model.defer="mr_no" id="mr_no" />
                    @error('mr_no') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label for="employee_id" class="text-sm">Person Accountable</label>
                    <select disabled id="employee_id" wire:model.defer="employee_id"
                        class="p-2 text-sm border-2 rounded-md border-zinc-200">
                        <option value="">{{ $name }}</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="unit_id" class="text-sm">Current Location</label>
                    <select disabled id="unit_id" wire:model.defer="unit_id"
                        class="p-2 text-sm border-2 rounded-md border-zinc-200">
                        <option value="">{{ $unit_name }}</option>
                    </select>
                </div>

                <div>
                    <label for="acquired_date" class="text-sm">Acquired Date</label>
                    <x-bladewind::input type="date" size="small" add_clearing="false" wire:model.defer="acquired_date"
                        id="acquired_date" />
                    @error('acquired_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="remarks" class="text-sm">Remarks</label>
                    <x-bladewind::input placeholder="Enter remarks" size="small" add_clearing="false"
                        wire:model.defer="remarks" id="remarks" />
                    @error('remarks') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2 mt-2">

                    <x-bladewind::button x-on:click="open = false" wire:click="closeModal" class="w-full" color="red"
                        button_text_css="font-bold" size="small" outline="true">Cancel
                    </x-bladewind::button>

                    <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold"
                        size="small">Update
                    </x-bladewind::button>
                </div>
            </form>
        </div>s
    </div>
</div>