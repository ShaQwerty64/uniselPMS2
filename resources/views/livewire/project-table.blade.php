<div class="inside">
    <div class="tablediv1">
    <div class="tablediv2">
    <div class="tablediv3">
    @foreach ($PTJs as $PTJ)
        @php
        $bigModalColor = 'purple';
        $bigBtnClass = '';
        if ($PTJ->PTJ == 'CICT'){
            $bigModalColor = 'yellow';
            $bigBtnClass = 'cict-';
        }
        elseif ($PTJ->PTJ == 'Aset') {
            $bigModalColor = 'blue';
            $bigBtnClass = 'aset-';
        }
        else {
            $bigModalColor = 'green';
            $bigBtnClass = 'jpp-';
        }
        @endphp
        <x-adminlte-modal id="modalptj{{ $PTJ->PTJ }}" title="{{$PTJ->PTJ}}" theme="{{ $bigModalColor }}"
        icon="fas fa-info-circle" size='lg'>
            <div>Big Projects Count: {{ $PTJ->bigCount }}</div>
            <div>Sub Projects Count: {{ $PTJ->projectsCount }}</div>
            <div>Milestones Count: {{ $PTJ->PTJmilestonesCount() }}</div>
            <div>Tasks Count: {{ $PTJ->done_tasks_count . '/' . $PTJ->tasks_count }}</div>
            @php
                $x = 0;
                if ($PTJ->tasks_count != 0){
                    $x = $PTJ->done_tasks_count / $PTJ->tasks_count * 100;
                }
            @endphp
            <div class="progress">
                <div class="progress-done" style="width: {{ $x }}%"></div>
                <div class="progress-text">{{ $x }}%</div>
            </div>
            {{-- <div>Details: {{ $PTJ->details }}</div> --}}
            {{-- <div>
                Project Manager:
                @forelse ($PTJ->users as $user)
                    {{$user->name}} ({{$user->email}}),
                @empty
                    [None]
                @endforelse
            </div> --}}
        </x-adminlte-modal>
            {{-- button to open modal --}}
        <x-adminlte-button icon="fas fa-external-link-alt" data-toggle="modal" data-target="#modalptj{{ $PTJ->PTJ }}" class="ptj-butt"/>
        <x-adminlte-card title="{{ $PTJ->PTJ }} [{{$PTJ->projectsCount}}]" theme="{{$bigModalColor}}" class="z2" collapsible="{{$PTJ->projectsCount2 >= 5 ? 'collapsed' : ''}}">

            @forelse ($PTJ->sub_projects as $sub)
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
                        <td class="td h-scroll">
                            @foreach ($sub->users as $user)
                            <div class="mx-3">
                                <div class="subprojuser">{{ $user->name }}</div>
                                <div>{{ $user->email }}</div>
                            </div>
                            @endforeach
                        </td>
                        @endif

                        <td class="subprojname">
                            <x-adminlte-modal id="modalsub{{ $sub->id }}" title="{{$sub->name}}" theme="{{ $bigModalColor }}"
                            icon="fas fa-info-circle" size='lg'>
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
                            @php
                                $x = 0;
                                if ($sub->tasks_count != 0){
                                    $x = $sub->done_tasks_count / $sub->tasks_count * 100;
                                }
                            @endphp
                            <div class="progress">
                                <div class="progress-done" style="width: {{ $x }}%"></div>
                                <div class="progress-text">{{ $x }}%</div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-modal id="modalsubdelete{{ $sub->id }}" title="Delete {{ $sub->name }}?" theme="danger"
                                    icon="fa fa-lg fa-fw fa-trash" size='lg'>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button class="mr-auto" theme="danger" label="Delete" wire:click="subDelete('{{ $sub }}')"/>
                                        <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                                <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                                data-target="#modalsubdelete{{ $sub->id }}" />

                                <x-adminlte-modal id="modalsubmove{{ $sub->id }}" title="Move {{ $sub->name }} to Other Project?" theme="info"
                                icon="fas fa-suitcase" size='lg'>
                                    @livewire('add-user', ['is' => 'project','proj' => $sub, 'big' => $PTJ], key('sub'.$sub->id))
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button class="mr-auto" theme="info" label="Move" wire:click="moveProject({{ $sub->id }})"/>
                                        <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                                <x-adminlte-button class="mr-auto" theme="info" label="Move to Other Project" data-toggle="modal"
                                data-target="#modalsubmove{{ $sub->id }}" />

                                <x-adminlte-modal id="modalsubup{{ $sub->id }}" title="Upgrade {{ $sub->name }} to Big Project?" theme="warning"
                                icon="fas fa-level-up-alt" size='lg'>
                                    @livewire('upgrade-project',['subProj'=>$sub, 'PTJ'=> $PTJ->PTJ],key('subup'.$sub->id))
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                                <x-adminlte-button class="mr-auto" theme="warning" label="Upgrade Project" data-toggle="modal" data-target="#modalsubup{{ $sub->id }}" />

                                @livewire('user-remove', ['big'=> false, 'proj'=>$sub, 'name'=> $sub->name], key('subremove'.$sub->id))
                                <x-adminlte-button label="Close" data-dismiss="modal"/>
                            </x-slot>
                            </x-adminlte-modal>
                            {{-- button to open modal --}}
                            <x-adminlte-button label="{{ $sub->name }}" data-toggle="modal" data-target="#modalsub{{ $sub->id }}" class="projbutton"/>
                        </td>
                        <td class="td">
                            <div class="progress">
                                <div class="progress-done" style="width: {{ $x }}%"></div>
                                <div class="progress-text">{{ $x }}%</div>
                            </div>
                        </td>
                    </tr>

                @if ($loop->last)
                    </tbody>
                </table>
                @endif
            @empty @if ($PTJ->notHaveBig)
                <div class="empty">This PTJ does not have any project in the database.</div>
            @endif @endforelse

            @foreach ($PTJ->PTJbigProjects as $big)
                @php
                $bigName = $big->name . ' (' . $big->PTJ . ')';
                @endphp
                <x-adminlte-modal id="modalbig{{ $big->id }}" title="{{$bigName}}" theme="{{ $bigModalColor }}"
                icon="fas fa-info-circle" size='lg'>
                    <div>Details: {{ $big->details != null ? $big->details : '[None]' }}</div>
                    <div>
                        Project Manager:
                        @forelse ($big->users as $user)
                            {{$user->name}} ({{$user->email}}) @if (!$loop->last) , @endif
                        @empty
                            [None]
                        @endforelse
                    </div>
                    <div>Projects count: {{$big->sub_projects->count()}}</div>
                    <div>Milestones Count: {{ $big->milestones_count }}</div>
                    <div>Tasks Count: {{ $big->done_tasks_count . '/' . $big->tasks_count }}</div>
                    @php
                        $x = 0;
                        if ($big->tasks_count != 0){
                            $x = $big->done_tasks_count / $big->tasks_count * 100;
                        }
                    @endphp
                    <div class="progress">
                        <div class="progress-done" style="width: {{ $x }}%"></div>
                        <div class="progress-text">{{ $x }}%</div>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-modal id="modalbigdelete{{ $big->id }}" title="Delete {{ $bigName }}?" theme="danger"
                            icon="fa fa-lg fa-fw fa-trash" size='lg'>
                            <x-adminlte-button class="mr-auto" theme="danger" label="Delete with ALL the Projects Under this Project" wire:click="bigDelete({{ $big }}, true)"/>
                            <x-slot name="footerSlot">
                                <x-adminlte-button class="mr-auto" theme="danger" label="Delete Project and Move All Project Under this Project to Default PTJ" wire:click="bigDelete({{ $big }}, false)"/>
                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                            </x-slot>
                        </x-adminlte-modal>
                        <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                        data-target="#modalbigdelete{{ $big->id }}" />

                        @livewire('user-remove', ['big'=> true, 'proj'=>$big, 'name'=> $bigName], key('subremove'.$sub->id))

                        <x-adminlte-button label="Close" data-dismiss="modal"/>
                    </x-slot>
                </x-adminlte-modal>
                @php $subCount = $big->sub_projects->count();@endphp
                <div class="ptj-outside">
                    {{-- button to open modal --}}
                    <x-adminlte-button label="{{ $bigName }} [{{ $subCount }}]" data-toggle="modal"
                    data-target="#modalbig{{ $big->id }}" class="projbutton {{ $bigBtnClass }}sm ptj-sm"/>
                </div>
                <x-adminlte-card title="" theme="" class="" collapsible="{{$subCount >= 3 ? 'collapsed' : ''}}">
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
                                <td class="td h-scroll">
                                    @foreach ($sub->users as $user)
                                    <div class="mx-3">
                                        <div class="subprojuser">{{ $user->name }}</div>
                                        <div>{{ $user->email }}</div>
                                    </div>
                                    @endforeach
                                </td>
                                @endif
                                <td class="subprojname">
                                    <x-adminlte-modal id="modalsub{{ $sub->id }}" title="{{$sub->name}}" theme="{{ $bigModalColor }}"
                                    icon="fas fa-info-circle" size='lg'>
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
                                    @php
                                        $x = 0;
                                        if ($sub->tasks_count != 0){
                                            $x = $sub->done_tasks_count / $sub->tasks_count * 100;
                                        }
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-done" style="width: {{ $x }}%"></div>
                                        <div class="progress-text">{{ $x }}%</div>
                                    </div>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-modal id="modalsubdelete{{ $sub->id }}" title="Delete {{ $sub->name }}?" theme="danger"
                                            icon="fa fa-lg fa-fw fa-trash" size='lg'>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button class="mr-auto" theme="danger" label="Delete" wire:click="subDelete('{{ $sub }}')"/>
                                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                            </x-slot>
                                        </x-adminlte-modal>
                                        <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                                        data-target="#modalsubdelete{{ $sub->id }}" />

                                        <x-adminlte-modal id="modalsubmove{{ $sub->id }}" title="Move {{ $sub->name }} to Other Project?" theme="info"
                                        icon="fas fa-suitcase" size='lg'>
                                            @livewire('add-user', ['is' => 'project','proj' => $sub, 'big' => $big], key('sub'.$sub->id))
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button class="mr-auto" theme="info" label="Move" wire:click="moveProject({{ $sub->id }})"/>
                                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                            </x-slot>
                                        </x-adminlte-modal>
                                        <x-adminlte-button class="mr-auto" theme="info" label="Move to Other Project" data-toggle="modal"
                                        data-target="#modalsubmove{{ $sub->id }}" />

                                        <x-adminlte-modal id="modalsubup{{ $sub->id }}" title="Upgrade {{ $sub->name }} to Big Project?" theme="warning"
                                        icon="fas fa-level-up-alt" size='lg'>
                                            @livewire('upgrade-project',['subProj'=>$sub, 'PTJ'=> $big->PTJ],key('subup'.$sub->id))
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                                            </x-slot>
                                        </x-adminlte-modal>
                                        <x-adminlte-button class="mr-auto" theme="warning" label="Upgrade Project" data-toggle="modal" data-target="#modalsubup{{ $sub->id }}" />

                                        @livewire('user-remove', ['big'=> false, 'proj'=>$sub, 'name'=> $sub->name], key('subremove'.$sub->id))
                                        <x-adminlte-button label="Close" data-dismiss="modal"/>
                                    </x-slot>
                                    </x-adminlte-modal>
                                    {{-- button to open modal --}}
                                    <x-adminlte-button label="{{ $sub->name }}" data-toggle="modal" data-target="#modalsub{{ $sub->id }}" class="projbutton"/>
                                </td>
                                <td class="td">
                                    <div class="progress">
                                        <div class="progress-done" style="width: {{ $x }}%"></div>
                                        <div class="progress-text">{{ $x }}%</div>
                                    </div>
                                </td>
                            </tr>

                        @if ($loop->last)
                            </tbody>
                        </table>
                        @endif
                    @empty
                        <div class="empty">This big project does not have any project in the database.</div>
                    @endforelse
                </x-adminlte-card>
            @endforeach
        </x-adminlte-card>
    @endforeach
    </div>
    </div>
    </div>
</div>
        {{-- @if ($modalActive)
    <x-adminlte-modal id="modaltable" title="{{$modalName}}" theme="{{ $modalColor }}"
        icon="fas fa-info-circle" size='lg' wire:poll.visible>
            @if ($isBig) <div>Project count: {{$modalProj->sub_projects()->count()}}</div> @endif
            <div>Details: {{ $modalProj->details }}</div>
            <div>
                Project Manager:
                @forelse ($modalProj->users as $user)
                    {{$user->name}} ({{$user->email}}),
                @empty
                    None...
                @endforelse
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-modal id="modaldelete" title="Delete {{ $modalName }}?" theme="danger"
                    icon="fa fa-lg fa-fw fa-trash" size='lg'>
                    <x-slot name="footerSlot">
                        <x-adminlte-button class="mr-auto" theme="danger" label="Delete Project" wire:click="projDelete"/>
                        <x-adminlte-button label="Close All" data-dismiss="modal"/>
                    </x-slot>
                </x-adminlte-modal>
                <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                data-target="#modaldelete" />

                @if (!$isBig)
                    <x-adminlte-modal id="modalmove" title="Move {{ $modalName }} to Other Project?" theme="info"
                    icon="fas fa-suitcase" size='lg'>
                        @livewire('add-user', ['is' => 'project','proj' => $modalProj, 'big' => $modalBigProj])
                        <x-slot name="footerSlot">
                            <x-adminlte-button label="Close All" data-dismiss="modal"/>
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button class="mr-auto" theme="info" label="Move to Other Project" data-toggle="modal"
                    data-target="#modalmove" />

                    <x-adminlte-button class="mr-auto" theme="warning" label="Upgrade Project" wire:click="dd"/>
                @endif

                <livewire:user-remove :big="$isBig" :pId="$modalProj->id" :name="$modalName">
                <x-adminlte-button label="Close" wire:click="offModal" data-dismiss="modal"/>
            </x-slot>
    </x-adminlte-modal>
        @endif --}}
    {{-- <x-adminlte-button label="{{ $modalName }}" wire:click="setModal(false, {{id}}, '{{name}}', '{{color}}', {{idProj}})" data-toggle="modal" data-target="#modaltable" class="buttonClass"/> --}}
