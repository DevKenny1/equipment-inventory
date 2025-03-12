<div class="flex flex-col size-full">
    <!-- loading element -->
    <!-- <div wire:loading class="absolute top-0 left-0 z-50 bg-zinc-900/30 size-full">
        <div class="flex items-center justify-center h-full">
            <x-bladewind::spinner size="omg" color="blue" />
        </div>
    </div> -->
    <!-- loading element -->
    <livewire:navbar />
    <div class="flex flex-col px-8 py-4 overflow-hidden grow ">
        <div class="mb-4">
            <x-bladewind::button wire:click="backToDashboard()" icon="arrow-left" radius="full" outline="true"
                button_text_css="font-bold" class="hover:bg-black">
                Back to dashboard
            </x-bladewind::button>
        </div>

        <div class="flex flex-col items-center gap-8 p-8 overflow-y-auto rounded-lg shadow-lg grow bg-zinc-50">
            <x-bladewind::alert show_close_icon="false">
                *Username must be at least 8 characters without any spaces.
                <br>
                *Default password is (username)-password
            </x-bladewind::alert>
            <form wire:submit.prevent="createUser" class="max-w-full p-4 shadow-md w-96">
                <h1 class="mb-2 text-2xl font-bold text-center font-inter">Create New User</h1>
                <div class="flex flex-col gap-4">
                    <!-- username -->
                    <div>
                        <label for="username" class="font-bold text-zinc-500">Username</label>
                        <x-bladewind::input placeholder="Enter username" add_clearing="false"
                            wire:model.defer="username" id="username" size="small" />
                        @error('username') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>
                    <!-- employee -->
                    <div x-data="{ search: '', selectedEmployee: '', employeeId: '', showDropdown: false }">
                        <label for="employee" class="font-bold text-zinc-500">Employee</label>

                        <!-- Custom Select -->
                        <div class="relative">
                            <div @click="showDropdown = !showDropdown"
                                class="w-full p-2 text-sm bg-white border-2 rounded-md cursor-pointer border-zinc-200">
                                <span x-text="selectedEmployee ? selectedEmployee : 'Select Employee'"></span>
                            </div>

                            <!-- Dropdown -->
                            <div x-show="showDropdown" @click.away="showDropdown = false"
                                class="absolute z-10 w-full h-40 mt-1 overflow-auto bg-white border border-gray-200 rounded-md shadow-md">

                                <!--  ADDED: Search Input -->
                                <input type="text" x-model="search" placeholder="Search Employee..."
                                    class="w-full p-2 text-sm border-b border-gray-200">

                                <!--  ADDED: Filtered Options -->
                                <template
                                    x-for="employee in {{ json_encode($employees) }}.filter(e => e.lastname.toLowerCase().includes(search.toLowerCase()) || e.firstname.toLowerCase().includes(search.toLowerCase()))"
                                    :key="employee . employee_id">
                                    <div @click="
                        selectedEmployee = `${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`;
                        employeeId = employee.employee_id;
                        showDropdown = false;
                        $wire.set('employee_id', employee.employee_id);
                    " class="p-2 cursor-pointer hover:bg-gray-100">
                                        <span
                                            x-text="`${employee.lastname.toUpperCase()}, ${employee.firstname.toUpperCase()}`"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!--  ADDED: Hidden Input to Sync Livewire -->
                        <input type="hidden" x-model.defer="employeeId" wire:model.defer="employee_id">

                        @error('employee_id') 
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- role -->
                    <div class="flex flex-col">
                        <label for="role" class="font-bold text-zinc-500">Role</label>
                        <select id="role" wire:model.defer="role"
                            class="p-2 text-sm border-2 rounded-md border-zinc-200">
                            <option value="0">Staff</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <!-- status -->
                    <div class="flex flex-col">
                        <label for="status" class="font-bold text-zinc-500">Status</label>
                        <select id="status" wire:model.defer="status"
                            class="p-2 text-sm border-2 rounded-md border-zinc-200">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <!-- button -->
                    <x-bladewind::button class="w-full" can_submit="true"
                        button_text_css="font-bold">Create</x-bladewind::button>
                </div>
            </form>
        </div>
    </div>
</div>