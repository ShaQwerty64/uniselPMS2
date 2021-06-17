@extends('adminlte::page')

@section('title', 'View Projects')

@section('content_header')
    <h1 class="m-0 text-dark">View Projects</h1>
@stop

@section('content')

@php
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @foreach ($SubProjects as $sub)
                        <div></div>
                        <div>{{$sub->big_project->PTJ}}</div>
                        <div>{{$sub->start_date}}</div>
                        <div>{{$sub->end_date}}</div>

                <div>

                    <h1> Project name:</h1>
                    <div class="form-control">
                        {{$sub->name}}
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea2">Project Details</label>
                        <div class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3">{{$sub->details}}</div>
                    </div>

                    <label for="sel3">Big Project Name:</label>
                    <div class="form-control">
                        {{$sub->big_project->PTJ}}
                    </div>

                    <label for="sel3">Milestone:</label>
                    <div class="form-control">
                        {{$sub->Milestone}}
                    </div>

                    <label for="sel4">Count:</label>
                    <div class="form-control">
                        {{$sub->Count}}
                    </div>

                    <label for="sel9">Task Count:</label>
                    <div class="form-control">
                        {{$sub->Task_Count}}
                    </div>

                    <label for="sel9">Milestone Count:</label>
                    <div class="form-control">
                        {{$sub->Milestone_Count}}
                    </div>



                    <label for="sel5">Start date:</label>
                    <div class="form-control">
                        {{$sub->start_date}}
                    </div>
                    <label for="sel6">End date:</label>
                    <div class="form-control">
                        {{$sub->end_date}}
                    </div>
                    @php
                        $x = toProg($sub->done_tasks_count,$sub->tasks_count);
                    @endphp
                    <label for="sel7">Progress bar:{{ $GLOBALS['toProgS'] }}%</label>
                    <x-adminlte-progress theme="blue" value={{$x}}/>
                </div>

                        @endforeach


                        {{-- <div> {{$bigProject->name}} </div>
		<div> {{$bigProject->details}} </div>
		<div> {{$bigProject->PTJ}} </div>
		<div> {{$bigProject->start_date}} </div>
		<div> {{$bigProject->end_date}} </div>


		<div> {{$subProject->details}} </div>
		<div> {{$subProject->PTJ}} </div>
		<div> {{$subProject->start_date}} </div>
		<div> {{$subProject->end_date}} </div>

                    @endforeach --}}

                    {{-- <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                <form>
                                    <div class="form-group">
                                      <label for="sel1">Select Project:</label>
                                      <select class="form-control" id="sel1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                      </select>


                                          <h1 class="card-title">Project Details</h1>





                                          <div class="card" style="width: 18rem;">
                                            <svg class="bd-placeholder-img card-img-top" width="100%" height="180%"
                                            <div class="card-body">

                                            </svg>
                                              </div>
                                        </div>
                                      </div>

                                 </form>

                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
@stop
