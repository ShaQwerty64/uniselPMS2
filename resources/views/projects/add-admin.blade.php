{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Add, Remove Admin, Viewer
        </h2>
    </x-slot>

    <div class="py-12"> --}}
@extends('adminlte::page')

@section('title', 'Add Admin')

@section('content_header')
    <h1 class="m-0 text-dark">Add, Remove Admin, Viewer</h1>
@stop

@section('content')

<div class="col-12">

    @can('modify admin')
    <div class="py-4">
    <h2 class="big-title">Admins list</h2>
    <div class="inside">

        <table class="mytable">
            <thead class="thead">
                <tr>
                    <th class="w-4/12 text-center">Name</th>
                    <th class="w-3/12 text-center">Email</th>
                    <th class="       text-center">Stasuses</th>
                    <th class="w-1/12 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @if ($userIsAdmin)
                    <tr>
                        <td class="td td1">
                            {{$user->name}}
                            <div class="you">(You)</div>
                        </td>
                        <td class="email">
                            {{$user->email}}
                        </td>
                        <td class="td td1">
                            @foreach ($user->getRoleNames() as $role)
                                @if ($role == 'admin')
                                    <div class="admin ">Admin</div>
                                @elseif ($role == 'super-admin')
                                    <div class="super-admin">Super Admin</div>
                                @elseif ($role == 'topMan')
                                    <div class="viewer">Viewer</div>
                                @elseif ($role == 'projMan')
                                    <div class="manager ">Project Manager</div>
                                @endif
                            @endforeach
                        </td>
                        <td class="td">
                            <form action="{{ route('addadmin.removeAdmin',$user) }}" method="post">
                                @csrf
                                <button type="submit" onclick="return alert('Cannot remove yourself, get other admin to remove you!') ? false : false" class="btn btn-xs btn-default text-danger mx-1 shadow">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
                @foreach ($admins as $admin)
                    <tr>
                        <td class="td">
                            {{$admin->name}}
                        </td>
                        <td class="email">
                            {{$admin->email}}
                        </td>
                        <td class="td td1">
                            @foreach ($admin->getRoleNames() as $role)
                                @if ($role == 'admin')
                                    <div class="admin">Admin</div>
                                @elseif ($role == 'super-admin')
                                    <div class="super-admin">Super Admin</div>
                                @elseif ($role == 'topMan')
                                    <div class="viewer">Viewer</div>
                                @elseif ($role == 'projMan')
                                    <div class="manager ">Project Manager</div>
                                @endif
                            @endforeach
                        </td>
                        <td class="td">
                            <form action="{{ route('addadmin.removeAdmin',$admin) }}" method="post">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to remove {{$admin->name}} from becoming an admin?')" class="remove ">remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @livewire('add-user', ['is' => 'admin'])
    </div>
    </div>
    @endcan

    @can('modify viewer')
    <div class="py-4">
    <h2 class="big-title">Viewers list</h2>
    <div class="inside">

        <table class="mytable">
            <thead class="thead">
                <tr>
                    <th class="w-4/12 text-center">Name</th>
                    <th class="w-3/12 text-center">Email</th>
                    <th class="       text-center">Stasuses</th>
                    <th class="w-1/12 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @if ($userIsViewer)
                    <tr>
                        <td class="td td1">
                            {{$user->name}}
                            <div class="you">(You)</div>
                        </td>
                        <td class="email">
                            {{$user->email}}
                        </td>
                        <td class="td td1">
                            @foreach ($user->getRoleNames() as $role)
                                @if ($role == 'admin')
                                    <div class="admin">Admin</div>
                                @elseif ($role == 'super-admin')
                                    <div class="super-admin">Super Admin</div>
                                @elseif ($role == 'topMan')
                                    <div class="viewer">Viewer</div>
                                @elseif ($role == 'projMan')
                                    <div class="manager ">Project Manager</div>
                                @endif
                            @endforeach
                        </td>
                        <td class="td">
                            <form action="{{ route('addadmin.removeViewer',$user) }}" method="post">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to remove {{$user->name}} from becoming a viewer?')" class="remove ">remove</button>
                            </form>
                        </td>
                    </tr>
                @endif
                @foreach ($viewers as $viewer)
                    <tr>
                        <td class="td">
                            {{$viewer->name}}
                        </td>
                        <td class="email">
                            {{$viewer->email}}
                        </td>
                        <td class="td td1">
                            @foreach ($viewer->getRoleNames() as $role)
                            @if ($role == 'admin')
                                <div class="admin">Admin</div>
                            @elseif ($role == 'super-admin')
                                <div class="super-admin">Super Admin</div>
                            @elseif ($role == 'topMan')
                                <div class="viewer">Viewer</div>
                            @elseif ($role == 'projMan')
                                <div class="manager ">Project Manager</div>
                            @endif
                            @endforeach
                        </td>
                        <td class="td">
                            <form action="{{ route('addadmin.removeViewer',$viewer) }}" method="post">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to remove {{$viewer->name}} from becoming a viewer?')" class="remove ">remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @livewire('add-user', ['is' => 'viewer'])
    </div>
    </div>
    @endcan

</div>

<style>
.w-4\/12{
    width: 33.333333%;
}
.w-3\/12{
    width: 25%;
}
.w-1\/12{
    width: 8.333333%;
}
.big-title{
    /* text-3xl */
    font-size: 1.875rem;
    line-height: 2.25rem;
    /* font-semibold */
    font-weight: 600;
    /* text-gray-800 */
    --tw-text-opacity: 1;
    color: rgba(31, 41, 55, var(--tw-text-opacity));
}
.inside{
    /* overflow-hidden */
    overflow: hidden;
    /* bg-white */
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    /* shadow-xl */
    --tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);

}
@media (min-width: 640px) {
    .inside {/* sm:rounded-lg */
        border-radius: 0.5rem/* 8px */;
    }
}
.mytable{
    /* min-w-full */
    min-width: 100%;
    /* divide-y */
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    /* divide-gray-200 */
    --tw-divide-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-divide-opacity));
}
.thead{
    /* bg-gray-50 */
    --tw-bg-opacity: 1;
    background-color: rgba(249, 250, 251, var(--tw-bg-opacity));
}
.tbody{
    /* bg-white */
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    /* divide-y */
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    /* divide-gray-200 */
    --tw-divide-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-divide-opacity));
}
.td{
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* text-center */
    text-align: center;
}
.td1{
    /* flex */
    display: flex;
    /* justify-center */
    justify-content: center;
}
.you{
    /* ml-2 */
    margin-left: 0.5rem/* 8px */;
    /* font-bold */
    font-weight: 700;
}
.email{
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
}
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
.remove{
    /* font-bold */
    font-weight: 700;
    /* text-red-500 */
    --tw-text-opacity: 1;
    color: rgba(239, 68, 68, var(--tw-text-opacity));
    /* other */
    --tw-bg-opacity: 0;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    --tw-divide-opacity: 0;
    border-color: rgba(255, 255, 255, var(--tw-divide-opacity));
}
</style>
@stop
    {{-- </div>
</x-app-layout> --}}
