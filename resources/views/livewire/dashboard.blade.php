<!-- change the margin left of this main element based on the width of the sidebar -->
<main :class="isSidebarOpen ? '!ml-80' : '!ml-0'"
    class="ml-0 flex h-full [@media(max-width:940px)]:!ml-0 overflow-y-hidden" x-data="{
   isSidebarOpen: false,
    activeTab: @entangle('tab').defer,
    changeTab(tab) {
        this.activeTab = tab;
        window.history.pushState({}, '', '?tab=' + tab);
    }
}">
    <x-sidebar-close-state />
    <livewire:sidebar />
    <div class="flex flex-col w-full h-full min-w-[940px]">
        <livewire:navbar />
        <div class="p-4 overflow-hidden grow">
            <div class="h-full border-4 rounded-lg bg-zinc-50 border-zinc-300">
                <!-- panels -->
                <!-- equipment -->
                <div class="size-full" x-show="activeTab == 'equipment'">
                    <livewire:equipment-tab />
                </div>
                <!-- equipment -->
                <!-- location -->
                <div class="size-full" x-show="activeTab == 'location'">
                    <livewire:location-tab />
                </div>
                <!-- location -->
                <!-- equipment types -->
                <div class="size-full" x-show="activeTab == 'equipment_types'">
                    <livewire:equipment-type-tab />
                </div>
                <!-- equipment types -->
                <!-- users -->
                <div class="size-full" x-show="activeTab == 'users'">
                    <livewire:users-tab />
                </div>
                <!-- users -->
                <!-- panels end -->
            </div>
        </div>
    </div>
    <livewire:modify-user />
    <livewire:edit-equipment-type />
    <livewire:edit-equipment />
    <livewire:edit-location />
</main>