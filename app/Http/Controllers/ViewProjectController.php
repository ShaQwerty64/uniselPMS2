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
        // $bigProjects = BigProject::get();

        // $SubProjects = SubProject::withCount(['tasks',
        // 'tasks as done_tasks_count' => function ($query){
        //     $query->where('done', true);
        // }])->get();

        $PTJs = BigProject::
        with(['sub_projects', 'sub_projects.users:id,name,email','milestones','milestones.tasks'])
        ->withCount(['milestones'])
        ->where('default',true)
        ->get(['id','name','PTJ','details']);
        foreach ($PTJs as $PTJ){
            $PTJ->PTJactive(true);
        }

        return view('projects.view',[
        'PTJs' => $PTJs,
        ]);
    }

    // public function something()
    // {
    //     $admin->removeRole('topMan');
    //     $request->banner('"' . $admin->name . '" not a viewer now.');
    //     return redirect()->route('addadmin');
    // }
}
