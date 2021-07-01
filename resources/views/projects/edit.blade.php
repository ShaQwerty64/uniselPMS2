@extends('adminlte::page')

@section('title', 'Your projects')

@section('content_header')
    <h1 class="m-0 text-dark">Your Projects</h1>
@stop

@section('content')
<style>
    .remove{
        /* font-bold */
        font-weight: 700;
        /* text-red-500 */
        --tw-text-opacity: 1;
        color: rgba(239, 68, 68, var(--tw-text-opacity));
        /* other */
        --tw-bg-opacity: 0;
        background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        --tw-divide-opacity: 0;
        border-color: rgba(255, 255, 255, var(--tw-divide-opacity));
    }
</style>
<div class="row"><div class="col-12"><div class="card"><div class="card-body">

    <form action="{{route('edit')}}" method="POST">@csrf<div class="d-flex mb-3">
        <label for="sel1" class="ml-3 pt-2">Select Big Project:</label>
        <input type="checkbox" name="isBig" id="isBig" checked hidden>
        <select class="ml-3 pr-5" name="id" id="id">
            @foreach ($projList['big'] as $proj)
                <option value="{{$proj['id']}}">{{$proj['name']}} (Big)</option>
            @endforeach
        </select>
        <x-adminlte-button class="ml-3" type="submit" label="Go" theme="info"/>
        {{-- <div class="ml-3 pt-2">Now: {{$sub->name}} (Sub)</div> --}}
    </div></form>

    <form action="{{route('edit')}}" method="POST">@csrf<div class="d-flex mb-3">
        <label for="sel1" class="ml-3 pt-2">Select Sub Project:</label>
        <select class="ml-3 pr-5" name="id" id="id">
            @foreach ($projList['sub'] as $proj)
                <option value="{{$proj['id']}}">{{$proj['name']}} (Sub)</option>
            @endforeach
        </select>
        <x-adminlte-button class="ml-3" type="submit" label="Go" theme="info"/>
        <div class="ml-3 pt-2">Now: {{$sub->name}} (Sub)</div>
    </div></form>

    <div class="d-flex">
        <label for="sel1" class="mr-3">Completion:</label>
        <x-adminlte-progress id="pbDinamic" value="5" theme="lighblue" class="w-100 mr-5" style="height: 25px" animated with-label/>
    </div>

    <br>

    @push('js')
        <script>
            $(document).ready(function() {
                let pBar = new _AdminLTE_Progress('pbDinamic');
                let inc = (val) => {
                    let v = pBar.getValue() + val;
                    return v > 100 ? 0 : v;
                };
                setInterval(() => pBar.setValue(inc(1)), 100);
            })
        </script>
    @endpush

    <form action="{{route('edit.sub',$sub)}}" method="POST">@csrf<div class="card" style="">
        <div class="p-1 mb-2 bg-info pl-2 text-white text-bold">Project Details & Dates</div>
        <textarea class="m-2" id="details" name="details" rows="2">{{$sub->details}}</textarea>

        <div class="d-flex">
            <div class="w-100 m-2">
                <label class="control-label" for="start_date">Start Date</label>
                <input class="form-control w-100" id="start_date" name="start_date" placeholder="MM/DD/YYY" type="date" value="{{$sub->start_date}}"/>
            </div>
            <div class="w-100 m-2">
                <label class="control-label" for="end_date">End Date</label>
                <input class="form-control " id="end_date" name="end_date" placeholder="MM/DD/YYY" type="date" value="{{$sub->end_date}}"/>
            </div>
            <x-adminlte-button class="btn-flat" type="submit" label="Save Details" theme="success" class="w-50 m-2" icon="fas fa-lg fa-save"/>
        </div>
    </div></form>


{{-- width: 78rem;reset --}}
    <form action="{{route('edit.sub.tasks',$sub)}}" method="post" id="save_tasks">@csrf
        @foreach ($sub->milestones as $mile)
            @php $mileIX = $loop->index @endphp
            <div class="card">
                <div class="p-1 mb-2 bg-info pl-2 text-white text-bold">Milestone {{$loop->iteration}}
                    <input class="form-control" id="{{$idArray[$mileIX][0]}}" name="{{$idArray[$mileIX][0]}}" placeholder="Milestone Name" type="text" value="{{$mile->name}}"/>
                    <div class="d-flex">
                        <div class="w-100 m-2">
                            <label class="control-label" for="date">Start Date</label>
                            <input class="form-control" id="{{$idArray[$mileIX][0]}}s" name="{{$idArray[$mileIX][0]}}s" placeholder="MM/DD/YYY" type="date" value="{{$mile->start_date}}"/>
                        </div>
                        <div class="w-100 m-2">
                            <label class="control-label" for="date">End Date</label>
                            <input class="form-control" id="{{$idArray[$mileIX][0]}}e" name="{{$idArray[$mileIX][0]}}e" placeholder="MM/DD/YYY" type="date" value="{{$mile->end_date}}"/>
                        </div>
                        <form action="{{route('edit.sub.del_mile',$mile)}}" method="post" class="">@csrf
                            <x-adminlte-button class="btn-flat" type="submit" label="Delete Milestone {{$loop->iteration}}" theme="danger" class="w-50 m-2" icon="fas fa-lg fa-trash"/>
                        </form>
                    </div>
                </div>
                <div>
                    <ul class="list-group m-3">
                        @foreach ($mile->tasks as $task)
                            @php $taskIX = $loop->index @endphp
                            <li class="list-group-item d-flex">
                                <input id="{{$idArray[$mileIX][1][$taskIX]}}d" name="{{$idArray[$mileIX][1][$taskIX]}}d" class="mr-3 mt-2" type="checkbox" value="1" aria-label="..." @if ($task->done) checked @endif/>
                                <input id="{{$idArray[$mileIX][1][$taskIX]}}" name="{{$idArray[$mileIX][1][$taskIX]}}" class="w-50" type="text" placeholder="Task {{$loop->iteration}}" value="{{$task->name}}"/>
                                <form action="{{route('edit.sub.del_task',$task)}}" method="post">@csrf<button class="remove" type="submit">Delete</button></form>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{route('edit.sub.add_task',$mile)}}" method="post">@csrf<div class="d-flex m-3">
                        <input id="name" name="name" class="w-75 ml-5 mr-3" type="text" placeholder="Add Task"/>
                        <x-adminlte-button class="btn-flat" type="submit" label="Add Task" theme="success" icon="fas fa-lg fa-save"/>
                    </div></form>
                </div>
            </div>
        @endforeach

        <form action="{{route('edit.sub.add_mile',$sub)}}" method="post">@csrf<div class="card">
            <div class="card-body">
                <span class="input-group-addon"> Add Milestone</span>
                <input id="name" name="name" type="text" class="form-control" placeholder="Milestone Name">
                <div class="d-flex">
                    <div class="w-100 m-2">
                        <label class="control-label" for="date">Start Date</label>
                        <input class="form-control w-100" id="start_date" name="start_date" placeholder="MM/DD/YYY" type="date"/>
                    </div>
                    <div class="w-100 m-2">
                        <label class="control-label" for="date">End Date</label>
                        <input class="form-control " id="end_date" name="end_date" placeholder="MM/DD/YYY" type="date"/>
                    </div>
                    <x-adminlte-button class="btn-flat" type="submit" label="Add Milestone" theme="success" class="w-50 m-2" icon="fas fa-lg fa-save"/>
                </div>
            </div>
        </div></form>

        <x-adminlte-button class="btn-flat" type="submit" form="save_tasks" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-lg" type="reset" form="save_tasks" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
    </form>

</div></div></div></div>
@stop

