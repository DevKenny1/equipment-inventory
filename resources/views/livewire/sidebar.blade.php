<div class="absolute top-0 left-0 z-10 flex flex-col h-full gap-8 py-4 pr-1 transition-transform border-r-2 w-80 bg-zinc-50 border-zinc-300"
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
        <button :class="activeTab == 'items' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'items'">
            <x-bladewind::icon name="archive-box" />
            <span>Items</span>
        </button>
        <!-- Equipment Type -->
        <button :class="activeTab == 'equipment type' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'equipment type'">
            <x-bladewind::icon name="wrench-screwdriver" />
            <span>Equipment Type</span>
        </button>
        <!-- Person Accountable -->
        <button :class="activeTab == 'person accountable' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'person accountable'">
            <x-bladewind::icon name="user" />
            <span>Person Accountable</span>
        </button>
        <!-- Divisions and Sections -->
        <button :class="activeTab == 'divisions and sections' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'divisions and sections'">
            <x-bladewind::icon name="building-office" />
            <span>Divisions and Sections</span>
        </button>
        <!-- Users -->
        <button :class="activeTab == 'users' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'users'">
            <x-bladewind::icon name="users" />
            <span>Users</span>
        </button>
        <!-- Logs -->
        <button :class="activeTab == 'logs' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'logs'">
            <x-bladewind::icon name="clipboard-document-list" />
            <span>Logs</span>
        </button>
    </div>
</div>