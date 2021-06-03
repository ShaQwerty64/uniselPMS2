<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AddAdminController extends Controller
{
    public function index()
    {
        //auth()->user()->assignRole('admin');
        $userEmail = [];
        $userEmail[] = auth()->user()->email;

        $admins = User::role('admin')->with(['roles'])
        ->whereNotIn('email', $userEmail)
        ->get();

        $viewers = User::role('topMan')->with(['roles'])
        ->whereNotIn('email', $userEmail)
        ->get();

        $user = auth()->user();
        $userIsAdmin = $user->hasRole('admin');
        //$admins->contains($user);
        $userIsViewer = $user->hasRole('topMan');
        //$viewers->contains($user);

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
            $request->session()->put('banner.m', '"' . $admin->name . '" not an admin now.');
            $request->session()->put('banner.t', '');
        }
        else
        { //Not accessable
            $request->session()->put('banner.m', 'Cannot remove yourself, get other to admin remove you!');
            $request->session()->put('banner.t', 'w');
        }
        return redirect()->route('addadmin');
    }

    public function destroyViewer(User $admin, Request $request)
    {
        $admin->removeRole('topMan');
        $request->session()->put('banner.m', '"' . $admin->name . '" not a viewer now.');
        $request->session()->put('banner.t', '');
        return redirect()->route('addadmin');
    }
}
