<nav class="flex items-center justify-end p-4 border-b-2 xs:justify-between bg-zinc-50 border-zinc-300">
    <h1 class="hidden text-lg font-bold font-inter lg:block">Philippine National Research Institute</h1>
    <h1 class="hidden text-lg font-bold xs:block font-inter lg:hidden">PNRI</h1>
    <div class="flex items-center gap-4">
        <p class="hidden font-bold xxs:block">{{$name}}@if(Auth::user()->role == 1)
            <span class="font-normal">(admin)</span>
        @else
            <span class="font-normal">(staff)</span>
        @endif
        </p>
        <div class="pl-4 border-l-4 border-zinc-300">
            <button><x-bladewind::icon type="solid" name="user-circle" class="!w-8 !h-8" /></button>
            <x-bladewind::dropmenu trigger="chevron-down-icon" padded="false" class="mt-5">

                <x-bladewind::dropmenu-item hover="false" class="rounded-md order border-zinc-300">
                    <x-bladewind::button wire:click="openChangeLoggedUserPassword()" can_submit="true" size="small"
                        button_text_css="font-bold text-md" color="blue" onclick="event.stopPropagation()">CHANGE
                        PASSWORD</x-bladewind::button>
                </x-bladewind::dropmenu-item>

                <x-bladewind::dropmenu-item hover="false" class="rounded-md order border-zinc-300">
                    <form action="{{ route('logout') }}" method="POST" class="w-full ">
                        @csrf
                        <x-bladewind::button can_submit="true" size="small" button_text_css="font-bold text-md"
                            class="w-full" color="red">LOGOUT</x-bladewind::button>
                    </form>
                </x-bladewind::dropmenu-item>
            </x-bladewind::dropmenu>
        </div>

    </div>
</nav>