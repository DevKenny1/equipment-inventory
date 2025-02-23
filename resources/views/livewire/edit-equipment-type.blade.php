<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
        <div class="p-6 rounded-lg bg-zinc-50 w-96">
            <h2 class="mb-4 text-xl font-bold text-center">Edit Equipment Type</h2>
            <form wire:submit.prevent="updateType">

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

                <div>
                    <div class="flex gap-2 my-2">
                        <x-bladewind::button x-on:click="open = false" outline="true" wire:click="deleteType"
                            class="w-full" color="red" button_text_css="font-bold" size="small" outline="true">Delete
                        </x-bladewind::button>

                        <x-bladewind::button class="w-full" can_submit="true" button_text_css="font-bold"
                            size="small">Update
                        </x-bladewind::button>

                    </div>

                    <x-bladewind::button x-on:click="open = false" wire:click="closeModal" class="w-full" color="red"
                        button_text_css="font-bold" size="small">Close
                    </x-bladewind::button>

                </div>
            </form>
        </div>
    </div>
</div>