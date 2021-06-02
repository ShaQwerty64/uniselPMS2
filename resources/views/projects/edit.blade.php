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

                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                                <html lang="en">
                                    <head>
                                      <title>Bootstrap Example</title>
                                      <meta charset="utf-8">
                                      <meta name="viewport" content="width=device-width, initial-scale=1">
                                      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                                    </head>
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
                                          <div class="row">
                                            <x-adminlte-input name="iLabel" label="Completion" placeholder="%"
                                                fgroup-class="col-md-6" disable-feedback/>

                                        </div>


                                            <div class="input-group">
                                                <span class="input-group-addon">Milestone</span>

                                                <input id="msg" type="text" class="form-control" name="msg" placeholder="Something">
                                              </div>
                                             <div>
                                              <ul class="list-group">
                                                <li class="list-group-item">
                                                    Task 1
                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                </li>
                                                <li class="list-group-item">
                                                  Task 2
                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                </li>
                                                <li class="list-group-item">
                                                    Task 3
                                                  <input class="form-check-input me-1" type="checkbox" value="" aria-label="...">
                                                  <li class="list-group-item">
                                                  <x-adminlte-input name="iLabel" label="" placeholder="Add Task"
                                                  fgroup-class="col-md-6" disable-feedback/>
                                              </ul>
                                        </div>
                                                   <span class="input-group-addon"> Add Milestone</span>
                                                   <input id="msg" type="text" class="form-control" name="msg" placeholder="Something">
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

