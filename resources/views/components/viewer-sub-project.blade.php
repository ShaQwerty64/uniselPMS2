<div>
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
</div>
