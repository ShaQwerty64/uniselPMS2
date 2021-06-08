@extends('adminlte::page')

@section('title', 'Your projects')

@section('content_header')
    <h1 class="m-0 text-dark">Your Projects</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">



                                    <body>

                                    <div class="container">


                                      <form>
                                        <div class="form-group">
                                          <label for="sel1">Select Project:</label>
                                          <select class="form-control" id="sel1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                          </select>
                                          <br>

                                          <label for="sel1">Completion:</label>
                                          <x-adminlte-progress id="pbDinamic" value="5" theme="lighblue" animated with-label/>

                                        @push('js')
                                            <script>
                                            $(document).ready(function() {

                                             let pBar = new _AdminLTE_Progress('pbDinamic');

                                            let inc = (val) => {
                                            let v = pBar.getValue() + val;
                                            return v > 100 ? 0 : v;
                                            };

                                            setInterval(() => pBar.setValue(inc(10)), 2000);
                                             })
                                            </script>
                                        @endpush


                                        </div>


                                            <div class="input-group">
                                                <span class="input-group-addon">Milestone </span>

                                                <input id="msg" type="text" class="form-control" name="msg" placeholder="Something">
                                              </div>
                                             <div>
                                              <ul class="list-group">
                                                <li class="list-group-item">

                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                  Task 1
                                                </li>
                                                <li class="list-group-item">

                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                  Task 2
                                                </li>
                                                <li class="list-group-item">

                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                  Task 3
                                                  <li class="list-group-item">
                                                  <x-adminlte-input name="iLabel" label="" placeholder="Add Task"
                                                  fgroup-class="col-md-6" disable-feedback/>
                                              </ul>
                                        </div>
                                                   <span class="input-group-addon"> Add Milestone</span>
                                                   <input id="msg" type="text" class="form-control" name="msg" placeholder="">
                                             </div>
                                        </div>
                                    </div>
                                      </form>
                                      <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                                    <x-adminlte-button class="btn-lg" type="reset" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>



                                    </body>
                                    </html>







                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

