<div>
@forelse ($big->sub_projects as $sub)
    @if ($loop->first)
    <table class="mytable">
        <thead class="thead">
            <tr>
                <th class="text-center" style="width: 34%">Name</th>
                <th class="text-center" style="width: 33%">Project</th>
                <th class="text-center" style="width: 33%">Progress</th>
            </tr>
        </thead>
        <tbody class="tbody">
    @endif
        <tr>
            @if ($sub->users->count() == 1)
            <td class="td">
                @foreach ($sub->users as $user)
                    <div class="subprojuser">{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                @endforeach
            </td>
            @elseif ($sub->users->count() == 0)
                <td class="td">[NONE]</td>
            @else
            <td class="td l-scroll">
                @foreach ($sub->users as $user)
                <div class="mx-3">
                    <div class="subprojuser">{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                </div>
                @endforeach
            </td>
            @endif

            <td class="subprojname">
                <x-adminlte-modal id="modalsub{{ $sub->id }}" title="{{$sub->name}}" theme="{{ $bigModalColor }}" icon="fas fa-info-circle" size='lg'>
                <div>Details: {{ $sub->details != null ? $sub->details : '[None]' }}</div>
                <div>
                    Project Manager:
                    @forelse ($sub->users as $user)
                        {{$user->name}} ({{$user->email}}) @if (!$loop->last) , @endif
                    @empty
                        [None]
                    @endforelse
                </div>
                <div>Milestones Count: {{ $sub->milestones_count }}</div>
                <div>Tasks Count: {{ $sub->done_tasks_count . '/' . $sub->tasks_count }}</div>
                <div>Start Date: {{toMyDate($sub->start_date)}}</div>
                <div>End Date: {{toMyDate($sub->end_date)}}</div>
                @php
                    $x = toProg($sub->done_tasks_count,$sub->tasks_count);
                @endphp
                <div class="progress">
                    <div class="progress-done" style="width: {{ $x }}%"></div>
                    <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                </div>
                <x-slot name="footerSlot">
                    <x-adminlte-modal id="modalsubdelete{{ $sub->id }}" title="Delete {{ $sub->name }}?" theme="danger" icon="fa fa-lg fa-fw fa-trash" size='lg'>
                        <x-slot name="footerSlot">
                            <x-adminlte-button class="mr-auto" theme="danger" label="Delete" wire:click="subDelete({{ $sub }})"/>
                            <x-adminlte-button label="Close All" data-dismiss="modal"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                    data-target="#modalsubdelete{{ $sub->id }}" />

                    <x-adminlte-modal id="modalsubmove{{ $sub->id }}" title="Move {{ $sub->name }} to Other Project?" theme="info" icon="fas fa-suitcase" size='lg'>
                        @livewire('add-user', ['isProject' => true,'proj' => $sub, 'big' => $big], key('sub'.$sub->id))
                        <x-slot name="footerSlot">
                            <x-adminlte-button class="mr-auto" theme="info" label="Move" wire:click="moveProject({{ $sub->id }})"/>
                            <x-adminlte-button label="Close All" data-dismiss="modal"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button class="mr-auto" theme="info" label="Move to Other Project" data-toggle="modal"
                    data-target="#modalsubmove{{ $sub->id }}" />

                    <x-adminlte-modal id="modalsubup{{ $sub->id }}" title="Upgrade {{ $sub->name }} to Big Project?" theme="warning" icon="fas fa-level-up-alt" size='lg'>
                        @livewire('upgrade-project',['subProj'=>$sub, 'PTJ'=> $big->PTJ],key('subup'.$sub->id))
                        <x-slot name="footerSlot">
                            <x-adminlte-button label="Close All" data-dismiss="modal"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button class="mr-auto" theme="warning" label="Upgrade Project" data-toggle="modal" data-target="#modalsubup{{ $sub->id }}" />

                    {{-- @livewire('user-remove', ['proj'=>$sub, 'name'=> $sub->name], key('subremove'.$sub->id)) --}}
                    <x-adminlte-modal id="modalsubprojremove{{$sub->id}}" title="Remove or add user from {{ $sub->name }}" theme="info" icon="fas fa-users" size='lg'>
                        @livewire('add-user', ['isManager' => true, 'proj' => $sub, 'name' => $sub->name])
                        Press the user input (not the button) if users list not refresh. Please reload the page after removing user.
                        <x-slot name="footerSlot">
                            <x-adminlte-button class="mr-auto" label="Reload Page" wire:click="reloadPage" theme="warning"/>
                            <x-adminlte-button label="Close All" data-dismiss="modal"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button class="mr-auto" theme="info" label="Remove or add users" data-toggle="modal" data-target="#modalsubprojremove{{$sub->id}}" />

                    <x-adminlte-button label="Close" data-dismiss="modal"/>
                </x-slot>
                </x-adminlte-modal>
                {{-- button to open modal --}}
                <x-adminlte-button label="{{ $sub->name }}" data-toggle="modal" data-target="#modalsub{{ $sub->id }}" class="projbutton"/>
            </td>
            <td class="td">
                <div class="progress">
                    <div class="progress-done" style="width: {{ $x }}%"></div>
                    <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                </div>
            </td>
        </tr>

    @if ($loop->last)
        </tbody>
    </table>
    @endif
@empty @if ($big->notHaveBig)
    <div class="empty">This {{ $isPTJ }} does not have any project in the database.</div>
@endif @endforelse
</div>
