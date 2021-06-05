@extends('adminlte::page')

@section('title', 'Add Projects')

@section('content_header')
    <h1 class="m-0 text-dark">Add Projects</h1>
@stop

@section('content')

<x-my-css/>
@livewire('banner')
{{--
    $request->banner($message, 's');
    s = success
    w = warning
    d = danger
    '' = message
 --}}

<div class="col-12">
<div class="respon-2grid">

    <div class="py-4">
    <div class="outside outside1">
    <div class="inside inside1">
        @livewire('asign-project')
    </div>
    </div>
    </div>

    <div class="py-4">
    <div class="outside outside2">
    <div class="inside inside2">
        @livewire('project-table')
    </div>
    </div>
    </div>

</div>
</div>

@stop

@section('right-sidebar')
    Hi
@stop
