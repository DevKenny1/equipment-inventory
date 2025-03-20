<div x-data="{  isEditing: false }">
    <div
        class="absolute inset-0 top-0 left-0 z-40 flex items-start justify-center p-8 overflow-y-auto bg-black/50 size-full">

        <div class="flex flex-col gap-4 p-8 rounded-md size-full bg-zinc-50">
            <!-- loading element -->
            <div wire:loading class="absolute top-0 left-0 z-50 bg-zinc-900/30 size-full">
                <div class="flex items-center justify-center h-full">
                    <x-bladewind::spinner size="omg" color="blue" />
                </div>
            </div>
            <!-- loading element -->
            <!-- table -->
            <div class="overflow-y-auto grow font-jetbrains table-container">
                <x-bladewind::table has_border="true" divider="thin" celled="true">
                    <x-slot name="header">
                        <th>
                            <div>#</div>
                        </th>
                        <th>
                            <div>PERSON ACCOUNTABLE</div>
                        </th>
                        <th>
                            <div>SECTION/DIVISION</div>
                        </th>
                        <th>
                            <div>LOCATION</div>
                        </th>
                        <th>
                            <div>TRANSFER DATE</div>
                        </th>

                        <th>
                            <div>TRANSFER REMARKS</div>
                        </th>


                    </x-slot>
                    @foreach ($equipmentHistories as $equipmentHistory)
                        <tr
                            x-data="{ isEditing: false, remarks: @js($equipmentHistory->remarks), latestRemarks: @js($equipmentHistory->remarks), date_of_transfer: @js($equipmentHistory->date_of_transfer)}">
                            <td>
                                {{$loop->index + 1 + (($equipmentHistories->currentPage() - 1) * $itemPerPage)}}
                            </td>

                            <td>
                                {{ $equipmentHistory->name }}
                            </td>

                            <td>
                                {{ $equipmentHistory->section_division }}
                            </td>

                            <td>
                                {{ $equipmentHistory->location_description }}
                            </td>

                            <td>
                                <div>
                                    <input class="w-full rounded-md" type="date" size="small" add_clearing="false"
                                        x-model="date_of_transfer" onkeydown="return false;" readonly
                                        x-on:change="$wire.updateTransferDate(@js($equipmentHistory->equipment_transfer_history_id), date_of_transfer);" />

                                </div>
                            </td>

                            <td class="flex items-start gap-1 p-0">
                                <textarea x-bind:disabled="!isEditing" x-model.defer="remarks"
                                    style="background: transparent !important; color: gray !important;" size="small"
                                    add_clearing="false"
                                    class="p-0 bg-transparent border-none resize-none grow !disabled:bg-transparent !disabled:text-black"
                                    rows="3"></textarea>

                                <button x-show="!isEditing"
                                    class="block px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded-full active:scale-95"
                                    x-on:click="isEditing = true">
                                    Edit
                                </button>

                                <div x-show="isEditing" x-cloak>
                                    <button
                                        x-on:click="$wire.updateRemarks(@js($equipmentHistory->equipment_transfer_history_id), remarks); latestRemarks = remarks; isEditing = false;"
                                        class="block px-2 py-1 mb-1 text-xs font-bold text-white bg-green-500 rounded-full active:scale-95">
                                        <x-bladewind::icon class="font-bold size-4" name="check" /></button>
                                    <button
                                        class="block px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full active:scale-95"
                                        x-on:click="isEditing = false; remarks = latestRemarks">
                                        <x-bladewind::icon class="font-bold size-4" name="x-mark" />
                                    </button>
                                </div>
                            </td>
                    @endforeach
                </x-bladewind::table>

                <!-- no data message -->
                @if (!count($equipmentHistories))
                    <div class="mt-4">
                        <x-bladewind::empty-state image="/images/no-data.svg"
                            message="No data found."></x-bladewind::empty-state>
                    </div>
                @endif
                <!-- no data message -->
            </div>
            <!-- table -->
            <!-- links page -->
            <div class="font-nunito">
                {{ $equipmentHistories->onEachSide(1)->links() }}
                <div class="flex items-center w-full gap-2 mt-4 text-sm">
                    <p class="">Page: <span class="font-bold">{{ $equipmentHistories->currentPage() }}</span></p>
                    <p>Total history: <span class="font-bold">{{ $totalEquipmentHistories }}</span></p>
                    <!-- items per page -->
                    <div>
                        Items per page:
                        <select class="w-16 px-2" wire:model="itemPerPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="35">35</option>
                            <option value="40">40</option>
                            <option value="45">45</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <!-- items per page -->
                    <!-- sort order -->
                    <div>
                        Sort order:
                        <select class="px-2 w-28" wire:model="orderBySort">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <!-- sort order -->
                    <!-- close button -->
                    <x-bladewind::button x-on:click="isHistoryOpen = false" size="small" button_text_css="font-bold"
                        class="ml-auto">
                        close
                    </x-bladewind::button>
                    <!-- close button -->
                </div>
            </div>
            <!-- links page -->
        </div>
    </div>
</div>