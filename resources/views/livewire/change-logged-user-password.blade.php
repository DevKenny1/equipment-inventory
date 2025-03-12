<div x-data="{ open: @entangle('isOpen')}">
    <div x-show="open" x-cloak
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-4 overflow-y-auto bg-black/50 size-full">
        <form wire:submit.prevent="changePassword" class="p-6 rounded-lg bg-zinc-50 w-96">
            <h2 class="mb-4 text-xl font-bold text-center">Change Password</h2>
            <x-bladewind::alert show_close_icon="false">
                *Password must be at least 8 characters long
            </x-bladewind::alert>
            <div class="flex flex-col gap-2 mt-2">
                <div>
                    <label for="current_password">Enter current password</label>
                    <div class="flex gap-2">
                        <x-bladewind::input type="password" viewable="true" class="grow" add_clearing="false"
                            wire:model.defer="current_password" id="current_password"
                            placeholder="Enter your current password" />
                    </div>
                    @error('current_password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="new_password">Enter new password</label>
                    <div class="flex gap-2">
                        <x-bladewind::input type="password" viewable="true" class="grow" add_clearing="false"
                            wire:model.defer="new_password" id="new_password" placeholder="Enter your new password" />
                    </div>
                    @error('new_password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="confirm_new_password">Confirm new password</label>
                    <div class="flex gap-2">
                        <x-bladewind::input type="password" viewable="true" class="grow" add_clearing="false"
                            wire:model.defer="confirm_new_password" id="password"
                            placeholder="Confirm your new password" />
                    </div>
                    @error('confirm_new_password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex flex-col gap-2 mt-2">
                <x-bladewind::button can_submit="true" class="w-full" color="blue" button_text_css="font-bold"
                    size="small">Change
                </x-bladewind::button>
                <x-bladewind::button x-on:click="open = false" wire:click="closeModal" class="w-full" color="red"
                    button_text_css="font-bold" size="small">Close
                </x-bladewind::button>
            </div>
        </form>
    </div>
</div>