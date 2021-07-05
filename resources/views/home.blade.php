@extends('adminlte::page')

@section('title', 'Unisel PMS')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content') <div class="row">

    <div class="col-12"><div class="card"><div class="card-body">
        <p class="mb-0 font-weight-bold">You are logged in!</p>

        @unlessrole('admin|projMan|topMan')
            <p class="mb-0 font-weight-bold">Looks like you do not have any role, please tell admin to assign role to your user/account. User must be assigned to a role to get access to features.</p>
        @else
            <p class="mb-0 font-weight-bold">Hi {{Auth()->user()->name}}. You are a/an
                @foreach (Auth()->user()->getRoleNames() as $role)
                    @if ($role == 'admin')
                        admin
                    @elseif ($role == 'super-admin')
                        super admin
                    @elseif ($role == 'topMan')
                        viewer
                    @elseif ($role == 'projMan')
                        project manager
                    @endif
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
                .
            </p>
        @endunlessrole

    </div></div></div>

    <div class="col-12"><div class="card"><div class="card-body">
        @livewire('projects-history',['subject0'=>auth()->user()])
    </div></div></div>

    {{-- <div class="col-12"><div class="card"><div class="card-body">
        @livewire('super-admin-access')
    </div></div></div> --}}

</div> @stop
