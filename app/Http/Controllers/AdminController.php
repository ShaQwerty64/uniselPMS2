<?php

namespace App\Http\Controllers;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public Collection $PTJs;

    public function __construct()
    {
        $this->PTJs = BigProject::
        with(['sub_projects', 'sub_projects.users:id,name,email'])
        ->withCount(['milestones'])
        ->where('default',true)
        ->get(['id','name','PTJ','details']);
        foreach ($this->PTJs as $PTJ){
            $PTJ->PTJactive();
        }
    }

    public function index()
    {
        return view('projects.admin',[
            'PTJs' => $this->PTJs,
        ]);
    }

    public function destroy(BigProject $big, Request $request)
    {
        $PTJ = $this->findPTJ($big->PTJ)->id;
        foreach ($big->sub_projects as $sub) {
            $sub->big_project_id = $PTJ;
            $sub->save();
            $request->banner("Admin '"
            . auth()->user()->name
            .  "' move sub project '"
            . $sub->name . "' into "
            . $big->PTJ . " default"
            , ''
            , auth()->user()->id
            , null
            , $big->id
            , $sub->id
            , $big->PTJ
            );
        }

        $request->banner("Admin '" . auth()->user()->name
        .  "' delete big project '"
        . $big->name . "' ("
        . $big->PTJ . ")"
        , ''
        , auth()->user()->id
        , null
        , $big->id
        , null
        , $big->PTJ
        );

        $users = $big->users;
        $big->delete();

        foreach ($users as $user){
            if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
                $user->removeRole('projMan');
                //bannber
            }
        }

        return redirect()->route('admin');
    }

    public function destroyAll(BigProject $big, Request $request)
    {
        $request->banner("Admin '" . auth()->user()->name
        .  "' delete big project '"
        . $big->name . "' ("
        . $big->PTJ . ")"
        , ''
        , auth()->user()->id
        , null
        , $big->id
        , null
        , $big->PTJ
        );

        $subs = $big->sub_projects;
        $users = $big->users;
        $big->delete();

        foreach ($subs as $sub) {
            foreach ($sub->users as $user){
                if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
                    $user->removeRole('projMan');
                    //bannber
                }
            }
        }
        foreach ($users as $user){
            if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
                $user->removeRole('projMan');
                //bannber
            }
        }

        return redirect()->route('admin');
    }

    public function destroySub(SubProject $sub, Request $request)
    {
        $request->banner("Admin '" . auth()->user()->name
        .  "' delete sub project '"
        . $sub->name . "' ("
        . $sub->big_project->PTJ
        . ")"
        , ''
        , auth()->user()->id
        , null
        , $sub->big_project->id
        , $sub->id
        , $sub->big_project->PTJ
        );

        $users = $sub->users;
        $sub->delete();

        foreach ($users as $user){
            if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
                $user->removeRole('projMan');
                //bannber
            }
        }

        return redirect()->route('admin');
    }

    private function findPTJ(string $PTJPTJ): BigProject{
        foreach ($this->PTJs as $PTJ) {
            if ($PTJ->PTJ == $PTJPTJ){
                return $PTJ;
            }
        }
    }
}
