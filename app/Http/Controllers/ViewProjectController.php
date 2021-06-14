<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewProjectController extends Controller
{
    public function index ()
    {
        // $users = DB::table('users')
        //         ->select(DB::raw('count(*)as user_count,status'))
        //         ->where ('status','<>',1)
        //         ->groupBy('status')
        //         ->get();
        // $users = User::where('status','<>',1)
        // ->groupBy('status')
        // ->get('name','status');
        // $users_count = $users->count();

        // $users= User::get();
        $bigProjects = BigProject::get();
        $SubProjects = SubProject::get();
        return view('projects.view',[
        'user' => $user,
        'managers' => $managers,
        'admins' => $admins,
        'viewers' => $viewers,
        'userIsManager' => $userIsManager,
        'userIsAdmin' => $userIsAdmin,
        'userIsViewer' => $userIsViewer,
    ]);
    }

    public function something()
    {
        $admin->removeRole('topMan');
        $request->banner('"' . $admin->name . '" not a viewer now.');
        return redirect()->route('addadmin');
    }
}
