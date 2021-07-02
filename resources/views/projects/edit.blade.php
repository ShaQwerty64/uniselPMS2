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
        <x-adminlte-progress id="pbDinamic" value="{{prog($sub)}}" theme="lighblue" class="w-100 mr-5" style="height: 25px" animated with-label/>
        <input type="number" id="progress" value={{$sub->tasks_count}} hidden>
        <input type="number" id="done" value={{$sub->done_tasks_count}} hidden>
    </div>

    <br>

    @php
        function prog($sub): int{
            $progress = $sub->tasks_count;
            $done = $sub->done_tasks_count;
            if ($progress == null || $progress == 0){
                return 0;
            }
            return $done / $progress * 100;
        }
    @endphp
    @push('js')
        <script>
            // $(document).ready(function() {
            //     let pBar = new _AdminLTE_Progress('pbDinamic');
            //     let inc = (val) => {
            //         let v = pBar.getValue() + val;
            //         return v > 100 ? 0 : v;
            //     };
            //     setInterval(() => pBar.setValue(inc(1)), 100);
            // })
            function del(id){
                let x     = document.getElementById(id + 1);
                let btn   = document.getElementById(id    );
                let name  = document.getElementById(id + 2);
                let start = document.getElementById(id + 3);
                let end   = document.getElementById(id + 4);
                let alert = document.getElementById(id + 5);
                if (x.value == 0){
                    x.value = 1;
                    btn.innerHTML = "Don't Delete";
                    name.disabled = true;
                    if (start != null) start.disabled = true;
                    if (end   != null) end.disabled   = true;

                    alert.hidden = false;
                }
                else{
                    x.value = 0;
                    btn.innerHTML = "Delete";
                    name.disabled = false;
                    if (start != null) start.disabled = false;
                    if (end   != null) end.disabled   = false;
                    alert.hidden = true;
                }
                // console.log(y.id + " X " + x.value);
            }
            let progress = document.getElementById('progress').value;
            let done = document.getElementById('done').value;
            function check(id){
                let checkbox = document.getElementById(id);
                let pBar = new _AdminLTE_Progress('pbDinamic');
                if (checkbox.checked) done++;
                else done--;
                if (progress != 0) pBar.setValue(done / progress * 100);
            }
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
                    <div id={{($mileIX + 1) * 10000 + 5}} hidden>Will Be Deleted</div>
                    <input class="form-control" id={{($mileIX + 1) * 10000 + 2}} name="{{$idArray[$mileIX][0]}}" placeholder="Milestone Name" type="text" form="save_tasks" value="{{$mile->name}}"/>
                    <div class="d-flex">
                        <div class="w-100 m-2">
                            <label class="control-label" for="date">Start Date</label>
                            <input class="form-control" id={{($mileIX + 1) * 10000 + 3}} name="{{$idArray[$mileIX][0]}}s" placeholder="MM/DD/YYY" type="date" form="save_tasks" value="{{$mile->start_date}}"/>
                        </div>
                        <div class="w-100 m-2">
                            <label class="control-label" for="date">End Date</label>
                            <input class="form-control" id={{($mileIX + 1) * 10000 + 4}} name="{{$idArray[$mileIX][0]}}e" placeholder="MM/DD/YYY" type="date" form="save_tasks" value="{{$mile->end_date}}"/>
                        </div>
                        <button class="btn btn-danger mt-3 ml-3 mr-3" id={{($mileIX + 1) * 10000}} form="no" onclick="del({{($mileIX + 1) * 10000}})">
                        Delete</button>
                        <input type="checkbox" id={{($mileIX + 1) * 10000 + 1}} name="{{$idArray[$mileIX][0]}}del" form="save_tasks" value=0 checked hidden>
                        {{-- <form action="{{route('edit.sub.del_mile',$mile)}}" method="post">@csrf
                            <x-adminlte-button type="submit" label="Delete Milestone {{$loop->iteration}}" theme="danger" class="w-50 m-2" icon="fas fa-lg fa-trash"/>
                        </form> --}}
                    </div>
                </div>
                <div>
                    <ul class="list-group m-3">
                        @foreach ($mile->tasks as $task)
                            @php $taskIX = $loop->index @endphp
                            <li class="list-group-item d-flex">
                                <div id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 5}} hidden>Will Be Deleted</div>

                                <input id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 3}} name="{{$idArray[$mileIX][1][$taskIX]}}d" class="mr-3 mt-2" type="checkbox" value="1"
                                aria-label="..." onclick="check({{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 3}})" form="save_tasks" @if ($task->done) checked @endif/>

                                <input id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 2}} name="{{$idArray[$mileIX][1][$taskIX]}}" class="w-50"
                                 type="text" placeholder="Task {{$loop->iteration}}" value="{{$task->name}}" form="save_tasks"/>

                                <button class="remove" id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10}} form="no" onclick="del({{($mileIX + 1) * 10000 + ($taskIX + 1) * 10}})">
                                Delete</button>

                                <input type="checkbox" id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 1}} name="{{$idArray[$mileIX][1][$taskIX]}}del" form="save_tasks" value=0 checked hidden>
                                {{-- <form action="{{route('edit.sub.del_task',$task)}}" method="post">@csrf<button class="remove" type="submit"></button></form> --}}
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex m-3">
                        <input id="{{$idArray[$mileIX][0]}}nt" name="{{$idArray[$mileIX][0]}}nt" class="w-75 ml-5 mr-3" type="text" placeholder="Add Task"/>
                        {{-- <x-adminlte-button class="btn-flat" type="submit" label="Add Task" theme="success" icon="fas fa-lg fa-save"/> --}}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card"><div class="card-body">
            <span class="input-group-addon"> Add Milestone</span>
            <input id="new_mile" name="new_mile" type="text" class="form-control" placeholder="Milestone Name">
            <div class="d-flex">
                <div class="w-100 m-2">
                    <label class="control-label" for="date">Start Date</label>
                    <input class="form-control w-100" id="new_mile_start" name="new_mile_start" placeholder="MM/DD/YYY" type="date"/>
                </div>
                <div class="w-100 m-2">
                    <label class="control-label" for="date">End Date</label>
                    <input class="form-control " id="new_mile_end" name="new_mile_end" placeholder="MM/DD/YYY" type="date"/>
                </div>
                {{-- <x-adminlte-button class="btn-flat" type="submit" label="Add Milestone" theme="success" class="w-50 m-2" icon="fas fa-lg fa-save"/> --}}
            </div>
        </div></div>

        <x-adminlte-button class="btn-flat" type="submit" form="save_tasks" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-lg" type="reset" form="save_tasks" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
    </form>

</div></div></div></div>
@stop

