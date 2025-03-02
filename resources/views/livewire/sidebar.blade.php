<div class="absolute top-0 left-0 z-10 flex flex-col h-full gap-8 py-4 pr-1 transition-transform border-r-2 hide-sidebar w-80 bg-zinc-50 border-zinc-300"
    :class="isSidebarOpen ? 'show-sidebar' : 'hide-sidebar'">
    <!-- Sidebar header -->
    <div class="flex items-center justify-between px-8">
        <div class="flex items-center gap-3">
            <x-pnri-logo class="!w-8 !h-8" />
            <p class="text-xl font-bold text-blue-500 font-inter">Menu</p>
        </div>
        <button @click="isSidebarOpen = false">
            <x-bladewind::icon name="bars-3" class="font-bold stroke-2 hover:text-blue-500 !w-8 !h-8" />
        </button>
    </div>
    <!-- Tab List -->
    <div class="flex flex-col gap-3 px-8 overflow-y-auto">
        <!-- Items -->
        <button :class="activeTab == 'equipment' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'equipment'">
            <x-bladewind::icon name="archive-box" />
            <span>Items</span>
        </button>
        <!-- Equipment Type -->
        <button :class="activeTab == 'equipment_types' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'equipment_types'">
            <x-bladewind::icon name="computer-desktop" />
            <span>Equipment Type</span>
        </button>
        <!-- Users -->
        @if (Auth::user()->role == 1)
            <button :class="activeTab == 'users' && 'active-tab'"
                class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
                @click="activeTab = 'users'">
                <x-bladewind::icon name="users" />
                <span>Users</span>
            </button>
        @endif
    </div>
</div>