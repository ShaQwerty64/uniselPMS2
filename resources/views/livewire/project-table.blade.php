<div class="inside">
    <div class="tablediv1">
    <div class="tablediv2">
    <div class="tablediv3">
    @forelse ($bigProjects as $bigProject)
        @if ($bigProject->name == 'CICT default')
            <div class="ptj-big cict-big">CICT</div>
        @elseif ($bigProject->name == 'Aset default')
            <div class="ptj-big aset-big">Aset</div>
        @elseif ($bigProject->name == 'JPP default')
            <div class="ptj-big jpp-big">JPP</div>
        @else
            @php
            $v = 'purple';
            $vc = '';
            if ($bigProject->PTJ == 'CICT'){
                $v = 'yellow';
                $vc = 'cict-sm';
            }
            elseif ($bigProject->PTJ == 'Aset') {
                $v = 'blue';
                $vc = 'aset-sm';
            }
            else {
                $v = 'green';
                $vc = 'jpp-sm';
            }
            @endphp
            <x-adminlte-modal id="modalbigproj{{ $bigProject->id }}" title="{{$bigProject->name}}" theme="{{ $v }}"
            icon="fas fa-info-circle" size='lg'>
            This is a something but bigger.
            </x-adminlte-modal>
            <div class="ptj-outside">
                {{-- button to open modal --}}
                <x-adminlte-button label="{{ $bigProject->name }}  ({{ $bigProject->PTJ }})"
                    data-toggle="modal" data-target="#modalbigproj{{ $bigProject->id }}" class="projbutton ptj-sm {{ $vc }}"/>
            </div>
        @endif

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
                        This is a something.
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
            <div class="empty"> No project yet.</div>
        @endif
        @endforelse
    @empty
        <div class="empty"> No project yet</div>
    @endforelse
    </div>
    </div>
    </div>
</div>
