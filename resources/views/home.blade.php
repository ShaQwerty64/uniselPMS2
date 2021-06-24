@extends('adminlte::page')

@section('title', 'Unisel PMS')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content') <div class="row">

    <div class="col-12"><div class="card"><div class="card-body">
        <p class="mb-0">You are logged in!</p>
    </div></div></div>

    <div class="col-12"><div class="card"><div class="card-body">
        @livewire('projects-history',['subject0'=>auth()->user()])
    </div></div></div>

    <div class="col-12"><div class="card"><div class="card-body">
        @livewire('super-admin-access')
    </div></div></div>

</div> @stop
