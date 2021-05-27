<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AddAdminController extends Controller
{
    public function index()
    {
        //auth()->user()->assignRole('admin');
        $userEmail = [];
        $userEmail[] = auth()->user()->email;

        $admins = User::role('admin')
        ->whereNotIn('email', $userEmail)
        ->get();

        $viewers = User::role('topMan')
        ->whereNotIn('email', $userEmail)
        ->get();

        $user = auth()->user();
        $userIsAdmin = $user->hasRole('admin');
        $userIsViewer = $user->hasRole('topMan');

        return view('projects.add-admin',[
            'admins' => $admins,
            'viewers' => $viewers,
            'user' => $user,
            'userIsAdmin' => $userIsAdmin,
            'userIsViewer' => $userIsViewer,
        ]);
    }

    public function destroyAdmin(User $admin, Request $request)
    {
        if (auth()->user()->email != $admin->email)
        {
            $admin->removeRole('admin');
        }
        else
        {
            $request->session()->flash('flash.banner', 'Cannot remove yourself, get other to admin remove you!');
            $request->session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->route('addadmin');
    }

    public function destroyViewer(User $admin)
    {
        $admin->removeRole('topMan');
        return redirect()->route('addadmin');
    }
}
