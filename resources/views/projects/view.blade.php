@extends('adminlte::page')

@section('title', 'View Projects')

@section('content_header')
    <h1 class="m-0 text-dark">View Projects</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @foreach ($SubProjects as $sub)
                        {{$sub->name}}
                    @endforeach

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
