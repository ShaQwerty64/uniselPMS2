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

            <div class="d-flex align-items-center">
                <p class="mb-0 font-weight-bold">Hi {{Auth()->user()->name}}. Your roles: </p>
                @foreach (Auth()->user()->getRoleNames() as $role)
                    @if ($role == 'admin')
                        <div class="admin">Admin</div>
                    @elseif ($role == 'super-admin')
                        <div class="super-admin">Super Admin</div>
                    @elseif ($role == 'topMan')
                        <div class="viewer">Viewer</div>
                    @elseif ($role == 'projMan')
                        <div class="manager">Project Manager</div>
                    @endif
                @endforeach
            </div>

        @endunlessrole

    </div></div></div>

    <div class="col-12"><div class="card"><div class="card-body">
        @livewire('projects-history',['subject0'=>auth()->user()])
    </div></div></div>

    <div class="col-12"><div class="card"><div class="card-body">
        <div class="d-flex align-items-center">
            <div class="admin mx-4">Admin</div>
            <p class="ml-4 mb-0 font-weight-bold"> can add project, and assign roles to users.</p>
        </div>
        <div class="d-flex align-items-center">
            <div class="viewer mx-4">Viewer</div>
            <p class="ml-4 mb-0 font-weight-bold"> can add access "Projects Viewer" page to view all the projects.</p>
        </div>
        <div class="d-flex align-items-center">
            <div class="manager text-center">Project Manager</div>
            <p class="mb-0 font-weight-bold"> will only be assigned to user that have project assigned to them, and can access "Projects Editor" to edit projects that assigned to them.</p>
        </div>
    </div></div></div>

    @role('admin') <div class="col-12"><div class="card"><div class="card-body">
        @livewire('delete-history')
    </div></div></div> @endrole

    {{-- <div class="col-12"><div class="card"><div class="card-body">
        @livewire('super-admin-access')
    </div></div></div> --}}

    <style>
        .admin{
            /* p-1 */
            padding: 0.25rem/* 4px */;
            /* m-1 */
            margin: 0.25rem/* 4px */;
            /* font-bold */
            font-weight: 700;
            /* text-white */
            --tw-text-opacity: 1;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
            /* bg-yellow-500 */
            --tw-bg-opacity: 1;
            background-color: rgba(245, 158, 11, var(--tw-bg-opacity));
            /* rounded-lg */
            border-radius: 0.5rem/* 8px */;
        }
        .super-admin{
            /* p-1 */
            padding: 0.25rem/* 4px */;
            /* m-1 */
            margin: 0.25rem/* 4px */;
            /* font-bold */
            font-weight: 700;
            /* text-white */
            --tw-text-opacity: 1;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
            /* bg-black */
            --tw-bg-opacity: 1;
            background-color: rgba(0, 0, 0, var(--tw-bg-opacity));
            /* rounded-lg */
            border-radius: 0.5rem/* 8px */;
        }
        .viewer{
            /* p-1 */
            padding: 0.25rem/* 4px */;
            /* m-1 */
            margin: 0.25rem/* 4px */;
            /* font-bold */
            font-weight: 700;
            /* text-white */
            --tw-text-opacity: 1;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
            /* rounded-lg */
            border-radius: 0.5rem/* 8px */;
            /* bg-gradient-to-r */
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
            /* from-blue-700 */
            --tw-gradient-from: #1d4ed8;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(29, 78, 216, 0));
            /* to-green-700 */
            --tw-gradient-to: #047857;
        }
        .manager{
            /* p-1 */
            padding: 0.25rem/* 4px */;
            /* m-1 */
            margin: 0.25rem/* 4px */;
            /* font-bold */
            font-weight: 700;
            /* text-white */
            --tw-text-opacity: 1;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
            /* bg-purple-700 */
            --tw-bg-opacity: 1;
            background-color: rgba(109, 40, 217, var(--tw-bg-opacity));
            /* rounded-lg */
            border-radius: 0.5rem/* 8px */;
        }
    </style>

</div> @stop
