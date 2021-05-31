<div class="inside">
    <div class="tablediv1">
    <div class="tablediv2">
    <div class="tablediv3">
    @forelse ($bigProjects as $bigProject)
        @php
        $bigModalColor = 'purple';
        $bigBtnClass = '';
        if ($bigProject->PTJ == 'CICT'){
            $bigModalColor = 'yellow';
            $bigBtnClass = 'cict-';
        }
        elseif ($bigProject->PTJ == 'Aset') {
            $bigModalColor = 'blue';
            $bigBtnClass = 'aset-';
        }
        else {
            $bigModalColor = 'green';
            $bigBtnClass = 'jpp-';
        }
        $bigName = '';
        if ($bigProject->default){
            $bigBtnClass .= 'big ptj-big';
            $bigName = $bigProject->PTJ;
        }
        else {
            $bigBtnClass .= 'sm ptj-sm';
            $bigName = $bigProject->name . ' (' . $bigProject->PTJ . ')';
        }
        @endphp
        <x-adminlte-modal id="modalbigproj{{ $bigProject->id }}" title="{{$bigName}}" theme="{{ $bigModalColor }}"
        icon="fas fa-info-circle" size='lg'>
        @if ($bigProject->default)
            Some BODY
        @else
            <div>Project count: {{$bigProject->sub_projects()->count()}}</div>
            <div>Details: {{ $bigProject->details }}</div>
            <div>
                Project Manager:
                @forelse ($bigProject->users as $user)
                    {{$user->name}} ({{$user->email}}),
                @empty
                    None...
                @endforelse
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" theme="danger" label="Delete" wire:click="bigDelete('{{ $bigProject->id }}')"/>
                <x-adminlte-button class="mr-auto" theme="info" label="Remove a user" wire:click="dd"/>
                <x-adminlte-button label="Close" data-dismiss="modal"/>
            </x-slot>
        @endif
        </x-adminlte-modal>
        <div class="ptj-outside">
            {{-- button to open modal --}}
            <x-adminlte-button label="{{ $bigName }}" data-toggle="modal"
            data-target="#modalbigproj{{ $bigProject->id }}" class="projbutton {{ $bigBtnClass }}"/>
        </div>

        @forelse ($bigProject->sub_projects as $project)
            @if ($loop->first)
            <table class="mytable">
                <thead class="thead">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Project</th>
                        <th class="text-center">Progress</th>
                    </tr>
                </thead>
                <tbody class="tbody">
            @endif

                <tr>
                    <td class="td">
                        <div class="subprojuser">{{ $project->users[0]->name }}</div>
                        <div>{{ $project->users[0]->email }}</div>
                    </td>
                    @php
                        $w = 'purple';
                        if ($bigProject->PTJ == 'CICT'){
                            $w = 'yellow';
                        }
                        elseif ($bigProject->PTJ == 'Aset') {
                            $w = 'blue';
                        }
                        else {
                            $w = 'green';
                        }
                    @endphp
                    <td class="subprojname">
                        <x-adminlte-modal id="modalsubproj{{ $project->id }}" title="{{$project->name}}" theme="{{ $w }}"
                        icon="fas fa-info-circle" size='lg'>
                        <div>Details: {{ $project->details }}</div>
                        <div>
                            Project Manager:
                            @forelse ($project->users as $user)
                                {{$user->name}} ({{$user->email}}),
                            @empty
                                None...
                            @endforelse
                        </div>
                        <x-slot name="footerSlot">
                            <x-adminlte-button class="mr-auto" theme="danger" label="Delete" wire:click="subDelete('{{ $project->id }}')"/>
                            <x-adminlte-button class="mr-auto" theme="info" label="Move to Other Project" wire:click="dd"/>
                            <x-adminlte-button class="mr-auto" theme="warning" label="Upgrade Project" wire:click="dd"/>
                            <x-adminlte-button class="mr-auto" theme="secondary" label="Remove a User" wire:click="dd"/>
                            <x-adminlte-button label="Close" data-dismiss="modal"/>
                        </x-slot>
                        </x-adminlte-modal>
                        {{-- button to open modal --}}
                        <x-adminlte-button label="{{ $project->name }}" data-toggle="modal" data-target="#modalsubproj{{ $project->id }}" class="projbutton"/>
                    </td>
                    <td class="td">
                        @php
                            $x = $project->progress;
                            if ($x == null){
                                $x = 0;
                            }
                        @endphp
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
        @if ($bigProject->notHaveBig())
            <div class="empty">This big project does not have any project.</div>
        @endif
        @endforelse
    @empty
        <div class="empty"> No project yet. Make one, so tables...</div>
    @endforelse
    </div>
    </div>
    </div>
</div>
