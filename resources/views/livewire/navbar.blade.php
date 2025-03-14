<nav class="flex items-center justify-end p-4 border-b-2 xs:justify-between bg-zinc-50 border-zinc-300">
    <h1 class="hidden text-lg font-bold font-inter lg:block">Philippine Nuclear Research Institute</h1>
    <h1 class="hidden text-lg font-bold xs:block font-inter lg:hidden">PNRI</h1>
    <div class="flex items-center gap-4">
        <p class="hidden font-bold xxs:block">{{$name}}@if(Auth::user()->role == 1)
            <span class="font-normal">(admin)</span>
        @else
            <span class="font-normal">(staff)</span>
        @endif
        </p>
        <div class="relative pl-4 border-l-4 border-zinc-300" x-data="{isOpen: false}">

            <button x-on:click="isOpen = ! isOpen">
                <x-bladewind::icon type="solid" name="user-circle" class="!w-8 !h-8" />
                <x-bladewind::icon type="solid" name="chevron-down" class="!w-6 !h-6" />
            </button>

            <div x-show="isOpen" x-cloak
                class="absolute right-0 flex flex-col w-48 gap-2 p-4 mt-2 border rounded-md bg-zinc-50 border-zinc-900">
                <x-bladewind::button x-on:click="isOpen = false" class="w-full"
                    wire:click="openChangeLoggedUserPassword()" size="small" button_text_css="font-bold text-md"
                    color="blue">CHANGE
                    PASSWORD</x-bladewind::button>
                <form action="{{ route('logout') }}" method="POST" class="w-full ">
                    @csrf
                    <x-bladewind::button can_submit="true" size="small" button_text_css="font-bold text-md"
                        class="w-full" color="red">LOGOUT</x-bladewind::button>
                </form>
            </div>
        </div>
    </div>
</nav>