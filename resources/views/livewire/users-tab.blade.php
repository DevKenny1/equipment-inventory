<div class="flex flex-col h-full gap-4 p-8">
    <!-- loading element -->
    <div wire:loading class="absolute top-0 left-0 z-50 bg-zinc-900/30 size-full">
        <div class="flex items-center justify-center h-full">
            <x-bladewind::spinner size="omg" color="blue" />
        </div>
    </div>
    <!-- loading element -->

    <!-- Search -->
    <div class="flex items-center gap-4">
        <form wire:submit.prevent="searchFilter" class="grow">
            <x-bladewind::input focused placeholder="Search..." wire:model.defer="searchString" add_clearing="false"
                size="regular" />
        </form>
        <select class="px-4 py-1 rounded-md w-44 min-w-32" wire:model="searchBy">
            <option value="lastname">Last name</option>
            <option value="firstname">First name</option>
            <option value="username">Username</option>
            <option value="date_created">Created</option>
        </select>
        <x-bladewind::button button_text_css="font-bold" size="small"
            wire:click="clearSearchString()">Refresh</x-bladewind::button>
        @if (Auth::user()->role == 1)
            <x-bladewind::button button_text_css="font-bold flex items-center gap-2" size="small"
                wire:click="createNewUser()">
                <x-bladewind::icon name="user-plus" type="solid" class="!w-4 !h-4" />
                Add new user</x-bladewind::button>
        @endif
    </div>
    <!-- Search -->

    <!-- table -->
    <div class="overflow-y-auto grow font-jetbrains table-container">
        <x-bladewind::table has_border="true" divider="thin" celled="true">
            <x-slot name="header">
                <th>
                    <div>#</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'lastname'
                    ])>NAME</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'username'
                    ])>USERNAME</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'status'
                    ])>STATUS</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'role'
                    ])>ROLE</div>
                </th>
                <th>
                    <div @class([
                        'text-blue-500 font-bold' => $orderByString == 'date_created'
                    ])>CREATED</div>
                </th>
                <th></th>
            </x-slot>
            @foreach ($users as $user)
                        <tr>
                            <td>{{$loop->index + 1 + (($users->currentPage() - 1) * $itemPerPage)}} </td>

                            <td> <span @class(
                                ['font-bold text-blue-500' => Auth::id() == $user->user_id]
                            )>{{$user->lastname}},
                                    {{$user->firstname}}</spa>
                            </td>

                            <td> <span @class(
                                ['font-bold text-blue-500' => Auth::id() == $user->user_id]
                            )>{{$user->username}}</span>
                            </td>

                            <td>
                                @if ($user->status == '1')
                                    <x-bladewind::tag label="active" color="green" />
                                @elseif($user->status == '0')
                                    <x-bladewind::tag label="inactive" color="yellow" />
                                @endif
                            </td>

                            <td>
                                @if ($user->role == '1')
                                    <x-bladewind::tag label="admin" color="blue" />
                                @elseif($user->role == '0')
                                    <x-bladewind::tag label="staff" color="gray" />
                                @endif
                            </td>

                            <td>{{ $user->date_created }}</td>

                            <td>
                                @if (Auth::user()->role == 1)
                                    <button wire:click="openEditUser({{ $user->user_id }})">
                                        <x-bladewind::icon name="wrench-screwdriver" class="text-blue-900" />
                                    </button>
                                @endif
                            </td>
            @endforeach
        </x-bladewind::table>

        <!-- no data message -->
        @if (!count($users))
            <div class="mt-4">
                <x-bladewind::empty-state image="/images/no-data.svg" message="No data found."></x-bladewind::empty-state>
            </div>
        @endif
        <!-- no data message -->
    </div>
    <!-- table -->

    <!-- links page -->
    <div>
        {{ $users->onEachSide(1)->links() }}
        <div class="flex items-center gap-2 mt-4 text-sm">
            <p class="">Page: <span class="font-bold">{{ $users->currentPage() }}</span></p>
            <p>Total users: <span class="font-bold">{{ $totalUsers }}</span></p>
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
            <!-- sort by -->
            <div>
                Sort by:
                <select class="px-2 w-28" wire:model="orderByString">
                    <option value="lastname">Name</option>
                    <option value="username">Username</option>
                    <option value="status">Status</option>
                    <option value="role">Role</option>
                    <option value="date_created">Created</option>
                </select>
            </div>
            <!-- sort by -->
            <!-- sort order -->
            <div>
                Sort order:
                <select class="px-2 w-28" wire:model="orderBySort">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <!-- sort order -->
        </div>
    </div>
    <!-- links page -->
</div>