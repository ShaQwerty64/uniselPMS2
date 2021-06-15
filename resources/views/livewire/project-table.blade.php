<div class="inside"> <div class="tablediv1"> <div class="tablediv2"> <div class="tablediv3">

    @php
        function toMyDate(null|string $date): string{
            if ($date == null){
                return '[Unset]';
            }else {
                $c = Carbon\Carbon::parse($date);
                return $c->format('j/m/Y') . ' - ' . $c->diffForHumans();
            }
        }
        function toProg(null|int $progressDone, null|int $progress): int{
            if ($progress == null || $progress == 0){
                $GLOBALS['toProgS'] = '- ';
                return 0;
            }
            $tem = $progressDone / $progress * 100;
            $GLOBALS['toProgS'] = $tem;
            return $tem;
        }
    @endphp

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

        <x-adminlte-modal id="modalptj{{ $PTJ->PTJ }}" title="{{$PTJ->PTJ}}" theme="{{ $bigModalColor }}" icon="fas fa-info-circle" size='lg'>
            <div>Big Projects Count: {{ $PTJ->bigCount }}</div>
            <div>Sub Projects Count: {{ $PTJ->projectsCount }}</div>
            <div>Milestones Count: {{ $PTJ->PTJmilestonesCount() }}</div>
            <div>Tasks Count: {{ $PTJ->done_tasks_count . '/' . $PTJ->tasks_count }}</div>
            @php
                $x = toProg($PTJ->done_tasks_count,$PTJ->tasks_count);
            @endphp
            <div class="progress">
                <div class="progress-done" style="width: {{ $x }}%"></div>
                <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
            </div>
        </x-adminlte-modal>

        {{-- button to open modal --}}
        <x-adminlte-button icon="fas fa-external-link-alt" data-toggle="modal" data-target="#modalptj{{ $PTJ->PTJ }}" class="ptj-butt"/>
        <x-adminlte-card title="{{ $PTJ->PTJ }} [{{$PTJ->projectsCount}}]" theme="{{$bigModalColor}}" class="z2" collapsible="{{$PTJ->projectsCount2 >= 5 ? 'collapsed' : ''}}">

        <x-sub-project-row :big="$PTJ" :bigModalColor="$bigModalColor" :isPTJ="'PTJ'"/>

            @foreach ($PTJ->PTJbigProjects as $big)

                @php $bigName = $big->name . ' (' . $big->PTJ . ')'; @endphp

                <x-adminlte-modal id="modalbig{{ $big->id }}" title="{{$bigName}}" theme="{{ $bigModalColor }}" icon="fas fa-info-circle" size='lg'>
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
                    <div>Start Date: {{toMyDate($big->start_date)}}</div>
                    <div>End Date: {{toMyDate($big->end_date)}}</div>
                    @php $x = toProg($big->done_tasks_count,$big->tasks_count);  @endphp
                    <div class="progress">
                        <div class="progress-done" style="width: {{ $x }}%"></div>
                        <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-modal id="modalbigdelete{{ $big->id }}" title="Delete {{ $bigName }}?" theme="danger" icon="fa fa-lg fa-fw fa-trash" size='lg'>

                            <form action="{{ route('admin.delAll',$big) }}" method="post">
                                @csrf           {{-- <x-adminlte-button class="mr-auto" theme="danger" label="Delete with ALL the Projects Under this Project" wire:click="bigDelete({{ $big }}, true)"/> --}}
                                <x-adminlte-button class="mr-auto my-2" theme="danger" label="Delete with ALL the Projects Under this Project"
                                type="submit" onclick="return confirm('Delete with ALL {{$big->name}} s sub projects?')"/>
                            </form>
                            <form action="{{ route('admin.del',$big) }}" method="post">
                                @csrf           {{-- <x-adminlte-button class="mr-auto" theme="danger" label="Delete Project and Move All Project Under this Project to Default PTJ" wire:click="bigDelete({{ $big }}, false)"/> --}}
                                <x-adminlte-button class="mr-auto my-2" theme="danger" label="Delete Project and Move All Project Under this Project to Default PTJ"
                                type="submit" onclick="return confirm('Delete {{$big->name}} and move all sub projects under this project to Default {{$big->PTJ}}?')"/>
                            </form>
                            <x-slot name="footerSlot">
                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                            </x-slot>
                        </x-adminlte-modal>
                        <x-adminlte-button class="mr-auto" theme="danger" label="Delete" data-toggle="modal"
                        data-target="#modalbigdelete{{ $big->id }}" />

                        {{-- @livewire('user-remove', ['proj'=>$big, 'name'=> $bigName], key('subremove'.$sub->id)) --}}
                        <x-adminlte-modal id="modalbigprojremove{{$big->id}}" title="Remove or add user from {{ $bigName }}" theme="info" icon="fas fa-users" size='lg'>
                            @livewire('add-user', ['isManager' => true, 'proj' => $big, 'name' => $bigName])
                            Press the user input (not the button) if users list not refresh. Please reload the page after removing user.
                            <x-slot name="footerSlot">
                                <form action="{{route('admin')}}"><x-adminlte-button class="mr-auto" label="Reload Page" type="submit" theme="warning"/></form>
                                <x-adminlte-button label="Close All" data-dismiss="modal"/>
                            </x-slot>
                        </x-adminlte-modal>
                        <x-adminlte-button class="mr-auto" theme="info" label="Remove or add users" data-toggle="modal" data-target="#modalbigprojremove{{$big->id}}" />

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
                    <x-sub-project-row :big="$big" :bigModalColor="$bigModalColor" :isPTJ="'big project'"/>
                </x-adminlte-card>

            @endforeach

        </x-adminlte-card>

    @endforeach

</div> </div> </div> </div>
