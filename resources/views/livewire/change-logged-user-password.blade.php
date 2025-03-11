<div x-data="{ open: @entangle('isOpen')}">
    <div x-show="open" x-cloak
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
        <div class="p-6 rounded-lg bg-zinc-50 w-96">
            <h2 class="mb-4 text-xl font-bold text-center">Change Password</h2>

            <x-bladewind::button x-on:click="open = false" wire:click="closeModal" class="w-full" color="red"
                button_text_css="font-bold" size="small">Close
            </x-bladewind::button>
        </div>
    </div>
</div>