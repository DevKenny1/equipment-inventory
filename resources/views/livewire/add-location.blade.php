<div x-show="add_location_open" x-cloak
    class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
    <div class="p-6 rounded-lg bg-zinc-50 w-96">
        <h2 class="mb-4 text-xl font-bold text-center">Add Location</h2>
        <form wire:submit.prevent="addLocation">

            <div class="mb-2">
                <label for="description">Description</label>
                <x-bladewind::input placeholder="Enter description" size="small" add_clearing="false"
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

            <div>
                <div class="flex gap-2 my-2">
                    <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold" size="small">Add
                    </x-bladewind::button>
                </div>

                <x-bladewind::button x-on:click="add_location_open = false" class="w-full" color="red"
                    button_text_css="font-bold" size="small">Close
                </x-bladewind::button>
            </div>
        </form>
    </div>
</div>