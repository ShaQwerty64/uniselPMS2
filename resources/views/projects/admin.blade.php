@extends('adminlte::page')

@section('title', 'UniselPMS Projects Adder')

@section('content_header')
    <h1 class="m-0 text-dark">Projects Adder</h1>
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
        <div>The assigned user will have "Project Manager" role and can access "Projects Editor" page to edit projects that assigned to them.</div>
    </div>
    </div>

    <div class="py-4">
    <div class="outside outside2">
    <div class="inside inside2">
        <x-livewire.project-table :ptjs="$PTJs"/>{{-- @livewire('project-table') --}}
    </div>
    </div>
    </div>

</div>
</div>

@stop

@section('right-sidebar')
    Hi
@stop
