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
                <div>
                    <img src="https://edureviews.com/course/wp-content/uploads/2020/04/download-150x150.jpg" class="rounded mx-auto d-block" alt="...">
                </div>

                @foreach ($SubProjects as $sub)
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


                        <label for="sel9">PTJ:</label>
                        <div class="form-control">
                            {{$sub->big_project->PTJ}}
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
                    @foreach($sub->milestones as $milestone)
                        <div>{{$milestone->name}}</div>
                        <div>{{$milestone->details}}</div>
                        <div>{{$milestone->start_date}}</div>
                        <div>{{$milestone->end_date}}</div>
                        @foreach ($milestone->tasks as $task)
                            <div>{{$task->name}} (@if ($task->done) Done @else Not done yet @endif)</div>
                            @if ($task->updated_at != null)  @else
                             @endif

                            {{$task->created_at }}
                            {{$task->updated_at == null}}
                        @endforeach
                    @endforeach
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



                    <x-adminlte-card title="Aset" theme="pink" icon="fas fa-lg fa-fan" removable collapsible>
                      <x-adminlte-card title="first project" theme="dark" icon="fas fa-lg fa-fan" removable collapsible>
                      </x-adminlte-card>
                    </x-adminlte-card>

                    <x-adminlte-card title="JPP" theme="pink" icon="fas fa-lg fa-fan" removable collapsible>

                      <x-adminlte-card title="first project" theme="dark" icon="fas fa-lg fa-fan" removable collapsible>
                      </x-adminlte-card>
                    </x-adminlte-card>


                          <x-adminlte-card title="CICT" theme="pink" icon="fas fa-lg fa-fan" removable collapsible>
                            <div class="row">
                                <div class="col-sm-6">
                                  <div class="card">
                                    <a href="#" class="btn btn-primary">Total Projects Counts</a>
                                    <div class="card-body">
                                   <p> 4(1+3) </p>


                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">

                                  <div class="card">
                                    <a href="#" class="btn btn-primary">Total Milestones & Tasks Counts</a>
                                    <div class="card-body">
                                       20 (Total Milestone) and     154(10 completed Task)

                                    </div>
                                  </div>
                                </div>



                              </div>
                              <x-adminlte-card title="First Project A (sub)" theme="green" icon="fas fa-lg fa-fan" removable collapsible>

                                <div class="row">
                                    <div class="col-sm-6">
                                      <div class="card">
                                        <a href="#" class="btn btn-primary">Datails</a>
                                        <div class="card-body">
                                       <p> First project added unisel pms <p>


                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">

                                      <div class="card">
                                        <a href="#" class="btn btn-primary">Project Managers</a>
                                        <div class="card-body">
                                       <p> shamim bin (samim@gmail.com) </p>
                                       <p> zihad (zihad@gmail.com) </p>

                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="card">
                                          <a href="#" class="btn btn-primary">Dates</a>
                                          <div class="card-body">
                                           <p> Start 1/6/2021 (4 weeks ago) </p>
                                           <p> End  20/6/ 2021 (3 days ago) </p>

                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">

                                        <div class="card">
                                          <a href="#" class="btn btn-primary">Total Milestone & Task Count</a>
                                          <div class="card-body">
                                         <p> 3 </p>

                                          </div>
                                        </div>
                                      </div>


                                  <br>
                                  <div class="d-flex flex-column">
                                   
                                    <p> Milestone 1-First Milestone  (Start 1/7/2021 End: 14/7 2021) </p>
                                 <br>
                                 <ul class="list-group">
                                    <li class="list-group-item">

                                      <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                     Task 1 -First Task  (Finish at 14/7/21)   
                                    </li>
                                    <li class="list-group-item">

                                      <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                      Task 2-xxxxx(created at 1/7/21)
                                    </li>

                               <br>

                                 <p> Milestone x-xx (Start 3/7/2021 End: 18/7/2021) </p>
                                 <br>
                                 <ul class="list-group">
                                    <li class="list-group-item">

                                      <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                     Task x-xxxxxxx
                                    </li>
                                    <li class="list-group-item">

                                      <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                      Task x-xxxxxx
                                    </li>

                                    <li class="list-group-item">

                                        <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                        Task x-xxxxxx
                                      </li>
                                      <li class="list-group-item">

                                        <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                        Task xxx
                                      </li>
                                 </ul>

                            </x-adminlte-card>
                            <x-adminlte-card title="Other Big Project(Big)" theme="purple" icon="fas fa-lg fa-fan" removable collapsible>

                            </x-adminlte-card>
                            <x-adminlte-card title="A Super Big Project(Big)" theme="purple" icon="fas fa-lg fa-fan" removable collapsible>

                            </x-adminlte-card>

                            <x-adminlte-card title=" Second Project,but First Project (Big)" theme="green" icon="fas fa-lg fa-fan" removable collapsible>

                                <div class="row-sm-6">
                                    <div class="card">
                                      <a href="#" class="btn btn-primary">Datails</a>
                                      <div class="card-body">
                                     <p> This is xsxxxbn  bbdjsd bsjsb </p>
                                     <p> This is xsxxxbn  bbdjsd bsjsb </p>

                                      </div>
                                    </div>

                                    <div class="row-sm-6">
                                        <div class="card">
                                          <a href="#" class="btn btn-primary">Project Manager</a>
                                          <div class="card-body">
                                          <p> thissjsj jbmbj  </p>
                                          </div>
                                        </div>
                                        <div class="row-sm-6">
                                            <div class="card">
                                              <a href="#" class="btn btn-primary">Dates</a>
                                              <div class="card-body">
                                                <p> Start 1/6/2021 </p>
                                                <p> End 2/7 2021 </p>
                                              </div>
                                            </div>
                                            <div class="row-sm-6">
                                                <div class="card">
                                                  <a href="#" class="btn btn-primary">Total Milestones & Tasks Counts</a>
                                                  <div class="card-body">
                                                  <p> 10 </p>
                                                  </div>
                                                </div>



                            <x-adminlte-card title=" First Project,but First Big Project (Sub)" theme="purple" icon="fas fa-lg fa-fan" removable collapsible>

                                <div class="row">
                                    <div class="col-sm-6">
                                      <div class="card">
                                        <a href="#" class="btn btn-primary">Datails</a>
                                        <div class="card-body">



                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">

                                      <div class="card">
                                        <a href="#" class="btn btn-primary">Project Managers</a>
                                        <div class="card-body">


                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="card">
                                          <a href="#" class="btn btn-primary">Dates</a>
                                          <div class="card-body">


                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">

                                        <div class="card">
                                          <a href="#" class="btn btn-primary">Total Milestone & Task Count</a>
                                          <div class="card-body">


                                          </div>
                                        </div>
                                    </div>

                                </x-adminlte-card>


                        </x-adminlte-card>






                </x-adminlte-card>

                </div>

            </div>
        </div>
    </div>
@stop
