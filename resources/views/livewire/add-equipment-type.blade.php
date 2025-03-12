<div x-show="add_equipment_type_open" x-cloak
    class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
    <div class="p-6 rounded-lg bg-zinc-50 w-96">
        <h2 class="mb-4 text-xl font-bold text-center">Add Equipment Type</h2>
        <form wire:submit.prevent="createType">

            <div class="mb-2">
                <label for="equipment_name">Equipment Name</label>
                <x-bladewind::input placeholder="Enter equipment name" size="small" add_clearing="false"
                    wire:model.defer="equipment_name" id="equipment_name" />
                @error('equipment_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-2">
                <label for="description">Description</label>
                <x-bladewind::input placeholder="Enter equipment description" size="small" add_clearing="false"
                    wire:model.defer="description" id="description" />
                @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- status -->
            <div class="flex flex-col">
                <label for="status" class="font-bold text-zinc-500">Status</label>
                <select id="status" wire:model.defer="status" class="p-2 text-sm border-2 rounded-md border-zinc-200">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>

            <div class="flex gap-2 mt-2">

                <x-bladewind::button x-on:click="add_equipment_type_open = false" class="w-full" color="red"
                    button_text_css="font-bold" size="small">Cancel
                </x-bladewind::button>

                <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold" size="small">Create
                </x-bladewind::button>
            </div>
        </form>
    </div>s
</div>