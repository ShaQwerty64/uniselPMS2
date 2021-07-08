@extends('adminlte::page')

@section('title', 'UniselPMS Projects Viewer')

@section('content_header')
    <h1 class="m-0 text-dark">Projects Viewer</h1>
@stop

@section('content')

<style>
    .progress{
    height: 1.5rem;
    /* relative */
    position: relative;
    /* flex-grow */
    flex-grow: 1;
    /* overflow-hidden */
    overflow: hidden;
    /* rounded-md */
    border-radius: 0.375rem/* 6px */;
    /* bg-gradient-to-b */
    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
    /* from-gray-400 */
    --tw-gradient-from: #9ca3af;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(156, 163, 175, 0));
    /* to-gray-500 */
    --tw-gradient-to: #6b7280;
    /* bg-clip-border */
    background-clip: border-box;
}
.progress-done{
    /* absolute */
    position: absolute;
    /* inset-0 */
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    /* transition */
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    /* rounded-md */
    border-radius: 0.375rem/* 6px */;
    /* bg-gradient-to-b */
    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
    /* from-green-600 */
    --tw-gradient-from: #059669;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(5, 150, 105, 0));
    /* to-green-400 */
    --tw-gradient-to: #34d399;
}
.progress-text{
    font-size: 1.1rem;
    line-height: .45rem;
    /* relative */
    position: relative;
    /* font-sans */
    font-family: Nunito, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* h-6 */
    height: 1.5rem/* 24px */;
    padding: 0.5rem;
    /* flex-grow */
    flex-grow: 1;
}
</style>

@php
    function toMyDate(null|string $date): string{
        if ($date == null){
            return '[Unset]';
        }else {
            $c = Carbon\Carbon::parse($date);
            return $c->format('j/m/Y') . ' (' . $c->diffForHumans() . ')';
        }
    }
    function toMyDateCarbon(null|Carbon\Carbon $date): string{
        if ($date == null){
            return '[Unset]';
        }else {
            return $date->format('j/m/Y g:ia');
        }
    }
    function toProg(null|int $progressDone, null|int $progress): int{
        if ($progress == null || $progress == 0){
            $GLOBALS['toProgS'] = '- ';
            return 0;
        }
        $tem = $progressDone / $progress * 100;
        $GLOBALS['toProgS'] = intval($tem);
        return $tem;
    }
@endphp

    <div class="row"><div class="col-12"><div class="card"><div class="card-body">

        @foreach ($PTJs as $PTJ) <x-adminlte-card title="{{$PTJ->PTJ}}" theme="purple" icon="fab fa-accusoft" collapsible="{{$loop->first ? '' : 'collapsed'}}">

            <div class="progress mb-2">
                <div class="progress-done" style="width: {{ toProg($PTJ->done_tasks_count,$PTJ->tasks_count) }}%"></div>
                <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="btn btn-primary">Total Projects Counts (Sub + Big)</div>
                        <div class="card-body text-center font-weight-bolder"><h4>
                            {{ $PTJ->sub_projects->count() + $PTJ->bigCount }} ({{ $PTJ->sub_projects->count() }} + {{ $PTJ->bigCount }})
                        </h4></div>
                    </div>
                </div>
                <div class="col-sm-6 d-flex">
                    <div class="card flex-grow-1">
                        <div class="btn btn-primary">Total Milestones</div>
                        <div class="card-body mx-auto">
                            <h4>{{ $PTJ->PTJmilestonesCount() }}</h4>
                        </div>
                    </div>
                    <div class="card flex-grow-1">
                        <div class="btn btn-primary">Total Tasks</div>
                        <div class="card-body mx-auto">
                            <div class=" d-flex">
                                <h4>{{ $PTJ->tasks_count }}</h4>
                                <div class="ml-2">{{ $PTJ->done_tasks_count }} completed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php $collapse = true; @endphp

            @foreach ($PTJ->sub_projects as $sub)
                <x-adminlte-card title="{{$sub->name}} (sub)" theme="green" icon="fas fa-tasks" collapsible="{{$collapse ? '' : 'collapsed'}}">
                    @php $collapse = false; @endphp
                    <div class="progress mb-2">
                        <div class="progress-done" style="width: {{ toProg($sub->done_tasks_count,$sub->tasks_count) }}%"></div>
                        <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Datails</div>
                                <div class=" card-body">
                                    <div class="text-center"> {{ $sub->details != null ? $sub->details : '- None -' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Project Managers</div>
                                <div class="card-body">
                                    @forelse ($sub->users as $user)
                                        <div class=" text-center w-100">{{$user->name}} ({{$user->email}})</div>
                                    @empty
                                        <div class=" text-center">- Nobody -</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Dates</div>
                                <div class="card-body">
                                    <div class="text-center">Start: {{toMyDate($sub->start_date)}}</div>
                                    <div class="text-center">End: {{toMyDate($sub->end_date)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 d-flex">
                            <div class="card h-100 mb-0 flex-grow-1">
                                <div class="btn btn-primary">Total Milestones</div>
                                <div class="h-25"></div>
                                <div class="card-body mx-auto">
                                    <h4>{{ $sub->milestones_count }}</h4>
                                </div>
                                <div class="h-25"></div>
                            </div>
                            <div class="card h-100 mb-0 flex-grow-1">
                                <div class="btn btn-primary">Total Tasks</div>
                                <div class="card-body mx-auto">
                                    <div class="h-25"></div>
                                    <div class=" d-flex">
                                        <h4>{{ $sub->tasks_count }}</h4>
                                        <div class="ml-2">{{ $sub->done_tasks_count }} completed</div>
                                    </div>
                                    <div class="h-25"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="d-flex flex-column">
                        @forelse ($sub->milestones as $milestone)
                        <div class="d-flex">
                            <h4 class="mr-2 font-weight-bold">{{$milestone->name}}</h4>
                            <p class="mr-2"> Milestone {{$loop->iteration}} - Start: {{toMyDate($milestone->start_date)}} End: {{toMyDate($milestone->end_date)}}</p>
                        </div>

                        <ul class="list-group">
                            @forelse ($milestone->tasks as $task)
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="font-weight-bold">{{$loop->iteration}} -  {{$task->name}}</div>
                                        @if ($task->done)
                                            <div class="text-primary ml-2 font-weight-bold bg-primary rounded px-1"> Done! </div>
                                        @endif
                                        <div class="ml-2 text-black-50">
                                            @if ($task->updated_at == null)
                                                Created at: {{toMyDateCarbon($task->created_at)}}
                                            @else
                                                Modified at: {{toMyDateCarbon($task->updated_at)}}
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                - No task yet -
                            @endforelse
                        </ul>

                        <br>
                        @empty
                            - No task yet -
                        @endforelse
                    </div>
                </x-adminlte-card>
            @endforeach

            @foreach ($PTJ->PTJbigProjects as $big)
                <x-adminlte-card title="{{$big->name}} (Big)" theme="green" icon="fas fa-tasks" collapsible="{{$collapse ? '' : 'collapsed'}}">
                    @php $collapse = false; @endphp
                    <div class="progress mb-2">
                        <div class="progress-done" style="width: {{ toProg($big->done_tasks_count,$big->tasks_count) }}%"></div>
                        <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Datails</div>
                                <div class="card-body">
                                    <div class="text-center"> {{ $big->details != null ? $big->details : '- None -' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Project Manager</div>
                                <div class=" card-body">
                                    @forelse ($big->users as $user)
                                        <div class=" text-center w-100">{{$user->name}} ({{$user->email}})</div>
                                    @empty
                                        <div class=" text-center">- Nobody -</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="card h-100 mb-0">
                                <div class="btn btn-primary">Dates</div>
                                <div class="card-body">
                                    <div class="text-center"> Start: {{toMyDate($big->start_date)}}</div>
                                    <div class="text-center">End: {{toMyDate($big->end_date)}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2 d-flex">
                            <div class="card h-100 mb-0 flex-grow-1">
                                <div class="btn btn-primary">Total Projects</div>
                                <div class="h-25"></div>
                                <div class="card-body mx-auto">
                                    <h4>{{ $big->sub_projects->count() }}</h4>
                                </div>
                                <div class="h-25"></div>
                            </div>
                            <div class="card h-100 mb-0 flex-grow-1">
                                <div class="btn btn-primary">Total Milestones</div>
                                <div class="h-25"></div>
                                <div class="card-body mx-auto">
                                    <h4>{{ $big->milestones_count }}</h4>
                                </div>
                                <div class="h-25"></div>
                            </div>
                            <div class="card h-100 mb-0 flex-grow-1">
                                <div class="btn btn-primary">Total Tasks</div>
                                <div class="card-body mx-auto">
                                    <div class="h-25"></div>
                                    <div class=" d-flex">
                                        <h4>{{ $big->tasks_count }}</h4>
                                        <div class="ml-2">{{ $big->done_tasks_count }} completed</div>
                                    </div>
                                    <div class="h-25"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($big->sub_projects as $sub)
                    <x-adminlte-card title="{{$sub->name}} (sub)" theme="green" icon="fas fa-tasks" collapsible="@if ($loop->first) collapsed @endif">
                        <div class="progress mb-2">
                            <div class="progress-done" style="width: {{ toProg($sub->done_tasks_count,$sub->tasks_count) }}%"></div>
                            <div class="progress-text">{{ $GLOBALS['toProgS'] }}%</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <div class="card h-100 mb-0">
                                    <div class="btn btn-primary">Datails</div>
                                    <div class=" card-body">
                                        <div class="text-center">{{ $sub->details != null ? $sub->details : '- None -' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="card h-100 mb-0">
                                    <div class="btn btn-primary">Project Managers</div>
                                    <div class=" card-body">
                                        @forelse ($sub->users as $user)
                                            <div class=" text-center w-100">{{$user->name}} ({{$user->email}})</div>
                                        @empty
                                            <div class=" text-center">- Nobody -</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="card h-100 mb-0">
                                    <div class="btn btn-primary">Dates</div>
                                    <div class="card-body">
                                        <div class="text-center">Start: {{toMyDate($sub->start_date)}} </div>
                                        <div class="text-center">End: {{toMyDate($sub->end_date)}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2 d-flex">
                                <div class="card h-100 mb-0 flex-grow-1">
                                    <div class="btn btn-primary">Total Milestones</div>
                                    <div class="h-25"></div>
                                    <div class="card-body mx-auto">
                                        <h4>{{ $sub->milestones_count }}</h4>
                                    </div>
                                    <div class="h-25"></div>
                                </div>
                                <div class="card h-100 mb-0 flex-grow-1">
                                    <div class="btn btn-primary">Total Tasks</div>
                                    <div class="card-body mx-auto">
                                        <div class="h-25"></div>
                                        <div class=" d-flex">
                                            <h4>{{ $sub->tasks_count }}</h4>
                                            <div class="ml-2">{{ $sub->done_tasks_count }} completed</div>
                                        </div>
                                        <div class="h-25"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="d-flex flex-column">
                            @forelse ($sub->milestones as $milestone)
                            <div class="d-flex">
                                <h4 class="mr-2 font-weight-bold">{{$milestone->name}}</h4>
                                <p class="mr-2"> Milestone {{$loop->iteration}} - Start: {{toMyDate($milestone->start_date)}} End: {{toMyDate($milestone->end_date)}}</p>
                            </div>
                            {{-- @if ($task->done) bg-success @endif --}}
                            <ul class="list-group">
                                @forelse ($milestone->tasks as $task)
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="font-weight-bold">{{$loop->iteration}} - {{$task->name}}</div>
                                            @if ($task->done)
                                                <div class="text-primary ml-2 font-weight-bold bg-primary rounded px-1"> Done! </div>
                                            @endif
                                            <div class="ml-2 text-black-50">
                                                @if ($task->updated_at == null)
                                                    Created at: {{toMyDateCarbon($task->created_at)}}
                                                @else
                                                    Modified at: {{toMyDateCarbon($task->updated_at)}}
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    - No task yet -
                                @endforelse
                            </ul>

                            <br>
                            @empty
                                - No task yet -
                            @endforelse
                        </div>
                    </x-adminlte-card>
                @endforeach
                </x-adminlte-card>
            @endforeach
        </x-adminlte-card> @endforeach

    </div></div></div></div>
@stop
