@extends('adminlte::page')

@section('title', ($permit ? $proj->name . ' - ' : '') . 'UniselPMS Editor' )

@section('content_header')
    @php if ($permit) $projIsBig = $proj instanceof App\Models\BigProject; @endphp
    <h1 class="m-0 text-dark">Projects Editor @if ($permit) | {{$proj->name}} @if ($projIsBig) (Big) @else () (Sub) @endif @endif</h1>
@stop

@section('content')@if ($permit)

@php
function prog($proj): int{
    $progress = $proj->tasks_count;
    $done = $proj->done_tasks_count;
    if ($progress == null || $progress == 0){
        return 0;
    }
    return $done / $progress * 100;
}
@endphp
@push('js')
<script>
    let save = document.getElementById("save");
    let save_delete = document.getElementById("save&delete");
    let deleteCount = 0;

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
            deleteCount++;
        }
        else{
            x.value = 0;
            btn.innerHTML = "Delete";
            name.disabled = false;
            if (start != null) start.disabled = false;
            if (end   != null) end.disabled   = false;
            alert.hidden = true;
            deleteCount--;
        }
        let delete_show = deleteCount != 0;
        save.hidden = delete_show;
        save_delete.hidden = ! delete_show;
        // console.log(y.id + " X " + x.value);
    }
    let progress = document.getElementById('progress').value;
    let done = document.getElementById('done').value;
    function check(id){
        let checkbox = document.getElementById(id);
        let pBar = new _AdminLTE_Progress('pbDinamic');
        if (checkbox.checked) done++;
        else done--;
        if (progress != 0) pBar.setValue(parseInt(done / progress * 100));
    }

    function moreTask(id){
        let idx = id * 10;
        showMoreTasks = ! document.getElementById(idx + 2).disabled;
        document.getElementById(idx).innerHTML = showMoreTasks ? 'Add More Tasks' : 'Undo Add More Tasks';
        for (let c = 2; c <= 5; c++) {
            input = document.getElementById(idx + c);
            input.disabled = showMoreTasks;
            input.hidden = showMoreTasks;
        }
    }
</script>
@endpush
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
</style>

@livewire('banner')

<div class="row"><div class="col-12"><div class="card"><div class="card-body">

    <form action="{{route('edit')}}" method="POST">@csrf<div class="d-flex mb-3">
        <label for="sel1" class="ml-3 pt-2">Select Project:</label>
        <select class="ml-3 pr-5" name="index" id="index" value="">
            @foreach ($projList as $projL)
                <option value="{{$projL['index']}}" @if ($proj->id == $projL['id'] && $projIsBig == $projL['isBig']) selected @endif>
                {{$projL['name']}} @if ($projL['isBig']) (Big) @else () (Sub) @endif</option>
            @endforeach
        </select>
        <x-adminlte-button class="ml-3" type="submit" label="Go" theme="info"/>
    </div></form>

    <div class="d-flex sticky-top">
        <label for="sel1" class="pr-3 rounded-left bg-white">Completion:</label>
        <x-adminlte-progress id="pbDinamic" value="{{prog($proj)}}" theme="lighblue" class="w-100 mr-5" style="height: 25px" animated with-label/>
        <input type="number" id="progress" value={{$proj->tasks_count}} hidden>
        <input type="number" id="done" value={{$proj->done_tasks_count}} hidden>
    </div>

    <br>

    <form action="{{$projIsBig ? route('edit.big',$proj) : route('edit.sub',$proj) }}" method="post" id="save_tasks">@csrf
        <div class="card bg-light">
            <div class="p-1 mb-2 bg-info pl-2 text-white text-bold">Project Details & Dates</div>
            <textarea class="m-2" id="details" name="details" rows="2">{{$proj->details}}</textarea>

            <div class="d-flex">
                <div class="w-100 m-2">
                    <label class="control-label" for="start_date">Start Date</label>
                    <input class="form-control w-100" id="start_date" name="start_date" placeholder="MM/DD/YYY" type="date" value="{{$proj->start_date}}"/>
                </div>
                <div class="w-100 m-2">
                    <label class="control-label" for="end_date">End Date</label>
                    <input class="form-control " id="end_date" name="end_date" placeholder="MM/DD/YYY" type="date" value="{{$proj->end_date}}"/>
                </div>
                {{-- <x-adminlte-button class="btn-flat" type="submit" label="Save Details" theme="success" class="w-50 m-2" icon="fas fa-lg fa-save"/> --}}
            </div>
        </div>

        @if (!$projIsBig)
            @foreach ($proj->milestones as $mile)
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
                        </div>
                    </div>
                    <div>
                        <ul class="list-group m-3">
                            @foreach ($mile->tasks as $task)
                                @php $taskIX = $loop->index @endphp
                                <li class="list-group-item d-flex bg-light">
                                    <div id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 5}} hidden>Will Be Deleted</div>

                                    <input id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 3}} name="{{$idArray[$mileIX][1][$taskIX]}}d" class="mr-3 mt-2" type="checkbox" value="1"
                                    aria-label="..." onclick="check({{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 3}})" form="save_tasks" @if ($task->done) checked @endif/>

                                    <input id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 2}} name="{{$idArray[$mileIX][1][$taskIX]}}" class="w-75"
                                    type="text" placeholder="Task {{$loop->iteration}}" value="{{$task->name}}" form="save_tasks"/>

                                    @if ($task->updated_at == null)
                                        <div class=" ml-2">Created {{$task->created_at->diffForHumans()}}</div>
                                    @else
                                        <div class=" ml-2">Updated {{$task->created_at->diffForHumans()}}</div>
                                    @endif

                                    <button class="remove" id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10}} form="no" onclick="del({{($mileIX + 1) * 10000 + ($taskIX + 1) * 10}})">
                                    Delete</button>

                                    <input type="checkbox" id={{($mileIX + 1) * 10000 + ($taskIX + 1) * 10 + 1}} name="{{$idArray[$mileIX][1][$taskIX]}}del" form="save_tasks" value=0 checked hidden>
                                </li>
                            @endforeach
                        </ul>

                        @foreach ([1,2,3,4,5] as $index)
                            <input id={{($mileIX + 1) * 100000 + $index}} name="{{$idArray[$mileIX][0]}}nt{{$index}}" class="w-75 ml-5 mb-3 mr-3" type="text" placeholder="Add Task"  @if(!$loop->first) hidden disabled @endif>
                        @endforeach

                        <button type="button" class="btn btn-default w-75 ml-5 mb-3 mr-3" id={{($mileIX + 1) * 100000}} form="no"
                         onclick="moreTask({{($mileIX + 1) * 10000}})">Add More Tasks</button>
                    </div>
                </div>
            @endforeach

            <div class="card"><div class="card-body bg-light">
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
        @endif
        <x-adminlte-button id="save" class="btn-flat" type="submit" form="save_tasks" label="Save" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button id="save&delete" class="btn-flat" type="submit" form="save_tasks" label="Save & Delete"
         onclick="return confirm('Delete all tasks & milestones that mark as (Will be deleted) and save?')" theme="success" icon="fas fa-lg fa-save" hidden/>

        <a href="{{$projIsBig ? route('edit.big',$proj) : route('edit.sub',$proj)}}" class="btn btn-outline-danger btn-flat ml-4" onclick="return confirm('Reload this page and reset all input?')">
            <i class="fas fa-lg fa-trash"></i>
            Reset
        </a>
    </form>

</div></div></div></div>
@else
    <h1>Your are not permited to edit this project...</h1>
@endif @stop
