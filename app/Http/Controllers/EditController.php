<?php

namespace App\Http\Controllers;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public $projList = [];
    public $bigOnly = true;
    public $user;

    public function construct()
    {
        $this->user = auth()->user();
        foreach ($this->user->sub_projects as $sub){
            $projList[] = [
                'name'  => $sub->name,
                'x'     =>['isBig' => false, 'id'=>$sub->id]
            ];
            $this->bigOnly = false;

        }
        foreach ($this->user->big_projects as $big){
            $projList[] = [
                'name'  => $big->name,
                'x'     => ['isBig' => true, 'id'=>$big->id]
            ];
        }
    }

    public function index()//projects
    {
        $this->construct();
        if ($this->bigOnly){
            return redirect()->route('edit.big', $this->user->big_projects()->first());
        }
        return redirect()->route('edit.sub', $this->user->sub_projects()->first());
    }

    public function goto(Request $request)//projects (post)
    {
        $x = $request->all()['x'];
        if ($x['isBig']){
            return redirect()->route('edit.big', BigProject::where('id',$x['id'])->first());
        }
        return redirect()->route('edit.sub', SubProject::where('id',$x['id'])->first());
    }

    public function indexBig(BigProject $big)//projects/big/{big:name}
    {
        $this->construct();
        return view('projects.edit',[
            'big' => $big,
            'projList' => $this->projList,
        ]);
    }

    public function indexSub(SubProject $sub)//projects/sub/{sub}
    {
        $this->construct();
        return view('projects.edit',[
            'sub' => $sub,
            'projList' => $this->projList,
        ]);
    }

    public function modifyBig(BigProject $big, Request $request)//projects/big/{big:name} (post)
    {
        $allReq = $request->all();
        $newBig = new BigProject;
        $newBig->details = $allReq['details'];
        $newBig->start_date = $allReq['start_date'];
        $newBig->end_date = $allReq['end_date'];

        // if ()

        return redirect()->route('edit.sub',$big->refresh());
    }

    public function modifySub(SubProject $sub, Request $request)//projects/sub/{sub} (post)
    {
        $allReq = $request->all();
        $newSub = new SubProject;
        $newSub->details = $allReq['details'];
        $newSub->start_date = $allReq['start_date'];
        $newSub->end_date = $allReq['end_date'];

        array_key_exists("miles1",$allReq);

        return redirect()->route('edit.sub',$sub->refresh());
    }
}
