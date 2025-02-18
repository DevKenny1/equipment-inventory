<div class="flex-col w-24 h-full gap-8 py-4 border-r-2 min-w-24 bg-zinc-50 border-zinc-300" :class="isSidebarOpen ? 'hidden' : 'flex'">
    <div class="flex justify-center">
        <button @click="isSidebarOpen = true">
            <x-pnri-logo class="!w-8 !h-8" />
        </button>
    </div>
    <div class="flex flex-col items-center gap-3 overflow-y-auto">
        <!-- Items -->
        <button :class="activeTab == 'items' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'items'">
            <x-bladewind::icon name="archive-box" />
        </button>
        <!-- Equipment Type -->
        <button :class="activeTab == 'equipment type' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'equipment type'">
            <x-bladewind::icon name="wrench-screwdriver" />
        </button>
        <!-- Person Accountable -->
        <button :class="activeTab == 'person accountable' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'person accountable'">
            <x-bladewind::icon name="user" />
        </button>
        <!-- Users -->
        <button :class="activeTab == 'users' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'users'">
            <x-bladewind::icon name="users" />
        </button>
        <!-- Logs -->
        <button :class="activeTab == 'logs' && 'active-tab'"
            class="flex items-center gap-3 p-2 font-semibold transition-colors rounded-lg text-start"
            @click="activeTab = 'logs'">
            <x-bladewind::icon name="clipboard-document-list" />
        </button>
    </div>
</div>