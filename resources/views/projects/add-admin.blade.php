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

@livewire('banner')
<x-my-css/>

<div class="col-12">

    <div class="py-4">
    <h2 class="big-title">Project Managers list</h2>
    <div class="inside">

        <table class="mytable">
            <thead class="thead">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Projects</th>
                    <th class="w-1/12 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @if ($userIsManager)
                    <tr>
                        <td class="td td1">
                            {{$user->name}}
                            <div class="you">(You)</div>
                        </td>
                        <td class="email">
                            {{$user->email}}
                        </td>
                        <td class="td">
                            @foreach ($user->big_projects as $big)
                                {{ $big->name }}(Big-{{ $big->PTJ }})
                            @if (!$loop->last) , @endif
                            @endforeach
                            @if ($user->big_projects->count() != 0 && $user->sub_projects->count() != 0)
                                ,
                            @endif
                            @foreach ($user->sub_projects as $sub)
                                {{ $sub->name }}({{ $sub->big_project->PTJ }})
                            @if (!$loop->last) , @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            <x-adminlte-modal id="modalM{{$user->id}}" title="Remove Projects from {{$user->name}}" theme="danger" icon="fas fa-lg fa-trash" size='lg'>
                                @livewire('remove-user-project', ['user' => $user], key('r'.$user->id))
                                <x-slot name="footerSlot">
                                    <x-adminlte-button label="Close" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                            <x-adminlte-button label="remove"  data-toggle="modal" data-target="#modalM{{$user->id}}" class="remove"/>
                        </td>
                    </tr>
                @endif
                @foreach ($managers as $manager)
                    <tr>
                        <td class="td">
                            {{$manager->name}}
                        </td>
                        <td class="email">
                            {{$manager->email}}
                        </td>
                        <td class="td">
                            @foreach ($manager->big_projects as $big)
                                {{ $big->name }}(Big-{{ $big->PTJ }})
                            @if (!$loop->last) , @endif
                            @endforeach
                            @if ($manager->big_projects->count() != 0 && $manager->sub_projects->count() != 0)
                                ,
                            @endif
                            @foreach ($manager->sub_projects as $sub)
                                {{ $sub->name }}({{ $sub->big_project->PTJ }})
                            @if (!$loop->last) , @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            <x-adminlte-modal id="modalM{{$manager->id}}" title="Remove Projects from {{$manager->name}}" theme="danger" icon="fas fa-lg fa-trash" size='lg'>
                                @livewire('remove-user-project', ['user' => $manager], key('r'.$manager->id))
                                <x-slot name="footerSlot">
                                    <x-adminlte-button label="Close" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                            <x-adminlte-button label="remove"  data-toggle="modal" data-target="#modalM{{$manager->id}}" class="remove"/>
                        </td>
                        <td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

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
                    <th class="w-1/12 text-center">Action</th>
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
        @livewire('add-user', ['isAdmin' => true])
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
                    <th class="w-1/12 text-center">Action</th>
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
        @livewire('add-user', ['isViewer' => true])
    </div>
    </div>
    @endcan

</div>
@stop
    {{-- </div>
</x-app-layout> --}}
