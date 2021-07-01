<?php

namespace App\Http\Controllers;

use App\Models\BigProject;
use App\Models\Milestone;
use App\Models\SubProject;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $sub->load(['milestones','milestones.tasks']);
            $idArray = [];
            $mileNo = 1;
        foreach ($sub->milestones as $mile){
            $idA = [];
            $idA[0] = $this->threeDigit('m',$mileNo);
                $idA[1] = [];
                $taskNo = 1;
            foreach ($mile->tasks as $task){
                $idA[1][] = $this->threeDigit('t',$mileNo,$taskNo);
                $taskNo ++;
            }
            $idArray[] = $idA;
            $mileNo ++;
        }
        // $idArray = [
            // ['m001',['t001001','t001002']],
            // ['m002',['t002001','t002002']]
        // ]
        return view('projects.edit',[
            'sub' => $sub,
            'projList' => $this->projList,
            'idArray' => $idArray,
        ]);
    }

    public function modifyBig(BigProject $big, Request $request)//projects/big/{big:name} (post)
    {
        $message = "Manager '" + Auth()->user()->name + "' change some details of big project '" . $big->name . "' to: ";
        $allReq = $request->all();
        $changes = false;
        if ($big->details != $allReq['details']){
            $changes = true;
            $big->details = $allReq['details'];
            $message .= "Details: '" . $allReq['details'] . "' ";
        }
        if ($big->start_date != $allReq['start_date']){
            $changes = true;
            $big->start_date = $allReq['start_date'];
            $message .= " Start Date: " . $allReq['start_date'] . " ";
        }
        if ($big->end_date != $allReq['end_date']){
            $changes = true;
            $big->end_date = $allReq['end_date'];
            $message .= " End Date: " . $allReq['end_date'];
        }

        if ($changes){
            $big->save();
            $request->banner($message,'s',null,Auth()->user()->id,$big->id, null,$big->PTJ);
        }
        return redirect()->route('edit.big',$big->refresh());
    }

    public function modifySub(SubProject $sub, Request $request)//projects/sub/{sub} (post)
    {
        $message = "Manager '" + Auth()->user()->name + "' change some details of sub project '" . $sub->name . "' to: ";
        $allReq = $request->all();
        $changes = false;
        if ($sub->details != $allReq['details']){
            $changes = true;
            $sub->details = $allReq['details'];
            $message .= "Details: '" . $allReq['details'] . "' ";
        }
        if ($sub->start_date != $allReq['start_date']){
            $changes = true;
            $sub->start_date = $allReq['start_date'];
            $message .= " Start Date: " . $allReq['start_date'] . " ";
        }
        if ($sub->end_date != $allReq['end_date']){
            $changes = true;
            $sub->end_date = $allReq['end_date'];
            $message .= " End Date: '" . $allReq['end_date'];
        }

        if ($changes){
            $sub->save();
            $request->banner($message,'s',null,Auth()->user()->id,$sub->big_project->id,$sub->id,$sub->big_project->PTJ);
        }
        return redirect()->route('edit.sub',$sub->refresh());
    }

    public function modifySubTasks(SubProject $sub, Request $request)
    {
        $miles = $sub->milestones->load('tasks');
        $allReq = $request->all();
        //find milestones first
        $aMiles = []; $c0 = 1;
        foreach ($allReq as $key => $req){
            if ($this->isExist($key,$c0)){
                $aMile = [];
                $aMile['name'] = $req;
                $s = $key . 's'; $aMile['start_date'] = $allReq[$s];
                $e = $key . 'e'; $aMile['end_date'] = $allReq[$e];
                unset($allReq[$key]); unset($allReq[$s]); unset($allReq[$e]);
                $aMiles[] = $aMile;
                $c0++;
            }
        }

        //find tasks for milestones
        $c0 = 1;
        foreach ($aMiles as $key => $aMile) {
            $c1 = 1;
            $aTasks = [];
            foreach ($allReq as $key => $req) {
                if ($this->isExist($key,$c0,$c1)){
                    $aTask =[];
                    $aTask['name'] = $req;
                    $d = $key . 'd'; $aTask['done'] = $allReq[$d];
                    unset($allReq[$key]);unset($allReq[$d]);
                    $aTasks[] = $aTask;
                    $c1++;
                }
                else{
                    break;
                }
            }
            $aMiles[$c0 - 1]['tasks'] = $aTasks;
            $c0++;
        }

        //compare with database and save
        $aMilesCount = count($aMiles);// 10 - 9
        $milesDiffNo = $aMilesCount - $miles->count();
        $changes = $milesDiffNo != 0;
        $c0 = 0;
        foreach ($miles as $mile) {
            $aMileNotToDelete = $c0 < $aMilesCount;
            if ($aMileNotToDelete
            && ($mile->name     != $aMiles[$c0]['name']
            || $mile->start_date!= $aMiles[$c0]['start_date']
            || $mile->end_date  != $aMiles[$c0]['end_date'])){
                $mile->name         = $aMiles[$c0]['name'];
                $mile->start_date   = $aMiles[$c0]['start_date'];
                $mile->end_date     = $aMiles[$c0]['end_date'];
                $mile->save();
                $changes = true;
            }
            //Delete if the new are more that old
            elseif (!$aMileNotToDelete){
                $aMile->delete();
            }

            if ($aMileNotToDelete){
                //compare tasks with database and save
                $aMileTasksCount = count($aMiles[$c0]['tasks']);
                $diffNo = $aMileTasksCount - $mile->tasks->count();//10 - 9 = -1, 0..9
                $changes = $diffNo != 0 || $changes;
                $c1 = 0;
                foreach ($mile->tasks as $task) {
                    if ($c1 < $aMileTasksCount
                    && ($task->name != $aMiles[$c0]['tasks'][$c1]['name'] || $task->done != $aMiles[$c0]['tasks'][$c1]['done'])){
                        $task->name = $aMiles[$c0]['tasks'][$c1]['name'];
                        $task->done = $aMiles[$c0]['tasks'][$c1]['done'];
                        $task->save();
                        $changes = true;
                    }
                    elseif ($c1 >= $aMileTasksCount){
                        $task->delete();
                    }
                    $c1++;
                }
                if ($diffNo > 0){
                    for ($x = $c1;$x < $c1 - 1 + $diffNo;$x++){
                        $task = new Task;
                        $task->milestone_id = $mile->id;
                        $task->name = $aMiles[$c0]['tasks'][$x]['name'];
                        $task->done = $aMiles[$c0]['tasks'][$x]['done'];
                        $task->save();
                    }
                }
            }
            $c0++;
        }
        //Add new milestones
        if ($milesDiffNo > 0){
            for ($x = $c0;$x < $c0 - 1 + $milesDiffNo;$x++){
                $mile = new Milestone;
                $mile->sub_project_id= $sub->id;
                $mile->name         = $aMiles[$x]['name'];
                $mile->start_date   = $aMiles[$x]['start_date'];
                $mile->end_date     = $aMiles[$x]['end_date'];
                $mile->save();
            }
        }

        if ($changes){
            $request->banner("Manager '" + Auth()->user()->name + "' change something (milesones & tasks) in sub project '" . $sub->name . "'",'s'
            ,null,Auth()->user()->id,$sub->big_project->id,$sub->id,$sub->big_project->PTJ);
        }

        return redirect()->route('edit.sub',$sub);
    }

    private $lastExist;
    private function isExist(string $name,int $mileId, int $taskId = null): bool
    {
        if ($taskId != null){
            return $this->threeDigit('t',$mileId,$taskId);
        }
        $this->lastExist = $this->threeDigit('m',$mileId);
        return $this->lastExist == $name;
    }

    private function threeDigit(string $name, int $id, int $id2 = null): string
    {
        $return = $name;
        if ($id < 10){
            $return .= '00' . $id;
        }
        elseif ($id < 100){
            $return .= '0' . $id;
        }
        elseif ($id < 1000){
            $return .= $id;
        }
        else{dd('Oh no, too much numbers');}

        if ($id2 == null){}
        elseif ($id2 < 10){
            $return .= '00' . $id2;
        }
        elseif ($id2 < 100){
            $return .= '0' . $id2;
        }
        elseif ($id2 < 1000){
            $return .= $id2;
        }
        else{dd('Oh no, too much water');}

        return $return;
    }
}
