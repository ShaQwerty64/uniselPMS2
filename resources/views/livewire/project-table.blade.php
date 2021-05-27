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
            <div class="ptj-outside">
                <div class="bigprojname">{{$bigProject->name}}</div>
                @if ($bigProject->PTJ == 'CICT')
                    <div class="ptj-sm cict-sm">(CICT)</div>
                @elseif ($bigProject->PTJ == 'Aset')
                    <div class="ptj-sm aset-sm">(Aset)</div>
                @else
                    <div class="ptj-sm jpp-sm">(JPP)</div>
                @endif
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
                    <td class="subprojname">{{ $project->name }}</td>
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
            <div class="empty"> No project yet</div>
        @endforelse
    @empty
        <div class="empty"> No project yet</div>
    @endforelse
    </div>
    </div>
    </div>
</div>
