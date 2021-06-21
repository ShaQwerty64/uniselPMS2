<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AddAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();// $userEmail[] = $user->email;

        $users = User::role(['admin','topMan','projMan'])
        ->with(['roles', 'big_projects:id,name,PTJ', 'sub_projects:id,big_project_id,name','sub_projects.big_project:id,PTJ'])// ->whereNotIn('email', $userEmail)
        ->get(['id','name','email']);

        $managers = []; $admins = []; $viewers = [];
        $userIsManager = false; $userIsAdmin = false; $userIsViewer = false;
        //$admins->contains($user);$user->hasRole('admin');
        foreach ($users as $usr){
            $isUser = $usr->id == $user->id;
            foreach ($usr->roles as $role){
                if ($role->name == 'projMan'){
                    if ($isUser) { $userIsManager = true; }
                    else { $managers[] = $usr; }
                }
                if ($role->name == 'admin'){
                    if ($isUser) { $userIsAdmin = true; }
                    else { $admins[] = $usr; }
                }
                if ($role->name == 'topMan'){
                    if ($isUser) { $userIsViewer = true; }
                    else { $viewers[] = $usr; }
                }
            }
        }

        return view('projects.add-admin',[
            'user' => $user,
            'managers' => $managers,
            'admins' => $admins,
            'viewers' => $viewers,
            'userIsManager' => $userIsManager,
            'userIsAdmin' => $userIsAdmin,
            'userIsViewer' => $userIsViewer,
        ]);
    }

    public function destroyAdmin(User $admin, Request $request)
    {
        if (auth()->user()->email != $admin->email)
        {
            $admin->removeRole('admin');
            $request->banner("Admin '" . auth()->user()->name .  "' remove user '" . $admin->name . "' admin role"
            ,''
            ,auth()->user()->id
            ,$admin->id
            );
        }
        return redirect()->route('addadmin');
    }

    public function destroyViewer(User $admin, Request $request)
    {
        $admin->removeRole('topMan');
        $request->banner("Admin '" . auth()->user()->name .  "' remove user '" . $admin->name . "' viewer role"
        ,''
        ,auth()->user()->id
        ,$admin->id
        );
        return redirect()->route('addadmin');
    }

    //remove project managers who do not have projects under them
    public function reRole(){
        foreach (User::role('projMan')->get(['id','name','email']) as $user){
            // if ($user->hasPermissionTo('edit projects')){
                // $user->revokePermissionTo('edit projects');
            // }$user->hasRole('projMan');
            $user->removeRole('projMan');
        }
        foreach (BigProject::all() as $bigProject){
            foreach ($bigProject->users as $user){
                $user->assignRole('projMan');
            }
            foreach ($bigProject->sub_projects as $subProject){
                foreach ($subProject->users as $user){
                    $user->assignRole('projMan');
                }
            }
        }
        return redirect()->route('addadmin');
    }
}
