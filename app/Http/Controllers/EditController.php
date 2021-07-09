<?php

namespace App\Http\Controllers;

use App\Models\BigProject;
use App\Models\Milestone;
use App\Models\SubProject;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public $projList = [];
    public $bigOnly = true;
    public $user;

    public function construct()
    {
        $this->user = auth()->user();
        $bigTem = [];//$subTem = [];
        foreach ($this->user->big_projects as $big){
            $bigTem[] = [
                'index' => 'B ' . $big->id,
                'name'  => $big->name,
                'isBig' => true,
                'id'    =>  $big->id
            ];
            foreach ($big->sub_projects as $sub) {
                $tem = [
                    'index' => 'S ' . $sub->id,
                    'name'  => $sub->name,
                    'isBig' => false,
                    'id'    =>  $sub->id
                ];
                $bigTem[] = $tem;
                // $subTem[] = $tem;
            }
        }
        $subDtem = [];
        foreach ($this->user->sub_projects as $sub){
            $tem = [
                'index' => 'S ' . $sub->id,
                'name'  => $sub->name,
                'isBig' => false,
                'id'    => $sub->id
            ];
            $subDtem[] = $tem;
            $this->bigOnly = false;
        }
        $this->projList = array_merge($subDtem,$bigTem);
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
        $x = explode(' ',$request->all()['index']);
        if ($x[0] == 'B') return redirect()->route('edit.big', BigProject::where('id',$x[1])->first());
        return redirect()->route('edit.sub', SubProject::where('id',$x[1])->first());//intval()
        // return abort(403,'Oh no... Go back and reload. That should fix it. The Database is not in Sync with the page.');
    }

    private function userIsPermited(BigProject|SubProject $proj): bool{
        //must run after $this->construct();
        foreach ($this->projList as $projL) {
            if ($proj->id == $projL['id'] && ($proj instanceof BigProject) == $projL['isBig'])
            return true;
        }
        return false;
    }

    public function indexBig(BigProject $big)//projects/big/{big:name}
    {
        $this->construct();
        if ($this->userIsPermited($big)){
            $big->load('sub_projects');
            $big->loadCount('milestones');
            $big->sub_projects->loadCount([
                'tasks',
                'tasks as done_tasks_count' => function ($query){
                    $query->where('done', true);
                },
                'milestones',
            ]);
            foreach ($big->sub_projects as $sub){
                $big->tasks_count += $sub->tasks_count;
                $big->done_tasks_count += $sub->done_tasks_count;
            }
            return view('projects.edit',[
                'proj' => $big,
                'projList' => $this->projList,
                'permit' => $this->userIsPermited($big),
            ]);
        }
        else return view('projects.edit',['permit' => false]);
    }

    public function indexSub(SubProject $sub)//projects/sub/{sub}
    {
        $this->construct();
        if ($this->userIsPermited($sub)){
            $sub->load(['milestones','milestones.tasks']);
            $sub->loadCount([
                'tasks',
                'tasks as done_tasks_count' => function ($query){
                    $query->where('done', true);
                },
            ]);
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
                'proj' => $sub,
                'projList' => $this->projList,
                'idArray' => $idArray,
                'permit' => true,
            ]);
        }
        else return view('projects.edit',['permit' => false]);
    }

    public function modifyBig(BigProject $big, Request $request)//projects/big/{big:name} (post)
    {
        $message = "Manager '" . Auth()->user()->name . "' change some details of big project '" . $big->name . "' to: ";
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
        return redirect()->route('edit.big', $big);
    }

    private function modifySub(SubProject $sub, Request $request, array $allReq)
    {
        $message = "Manager '" . Auth()->user()->name . "' change some details of sub project '" . $sub->name . "' to: ";
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
    }

    public function modifySubTasks(SubProject $sub, Request $request)
    {
        $allReq = $request->all();
        // dd($allReq);
        // $oldReq = $allReq;
        unset($allReq['_token']);

        $this->modifySub($sub,$request,$allReq);
        $sub->refresh();

        $miles = $sub->milestones->load('tasks');
        //find milestones first
        $aMiles = []; $c0 = 1;
        foreach ($allReq as $key => $req){
            if ($this->isExist($key,$c0)){
                $aMile = [];
                $aMile['key'] = $key;
                $aMile['name'] = $req;
                $s  = $key . 's'  ;$aMile['start_date'] = $allReq[$s];
                $e  = $key . 'e'  ;$aMile['end_date'  ] = $allReq[$e];
                $del= $key . 'del';$aMile['delete'    ] = $allReq[$del] == 1;
                unset($allReq[$key]); unset($allReq[$s]); unset($allReq[$e]);unset($allReq[$del]);
                $aMiles[] = $aMile;
                $c0++;
            }
            elseif ($this->isExist($key,$c0,null, 'del') && !$this->isExist($key,$c0)){
                $aMiles[] = ['delete' => $allReq[$key] == 1];
                unset($allReq[$key]);
                $c0++;
            }
        }

        //find tasks for milestones
        $c0 = 1;
        foreach ($aMiles as $aMile) {
            $c1 = 1;
            $aTasks = [];
            foreach ($allReq as $key => $req) {
                if ($this->isExist($key,$c0,$c1)){
                    $aTask =[];
                    $aTask['name'] = $req;
                    unset($allReq[$key]);

                    $d = $key . 'd';
                    if (array_key_exists($d,$allReq)){
                        $aTask['done'] = true;
                        unset($allReq[$d]);
                    }
                    else {$aTask['done'] = false;}

                    $del = $key . 'del';
                    $aTask['delete'] = $allReq[$del] == 1;
                    unset($allReq[$del]);

                    $aTasks[] = $aTask;
                    $c1++;
                }
                elseif ($this->isExist($key,$c0,$c1, 'del') && !$this->isExist($key,$c0,$c1)){
                    $aTasks[] = ['delete' => $allReq[$key] == 1];
                    unset($allReq[$key]);
                    $c1++;
                }
                // else{break;}
            }
            $aMiles[$c0 - 1]['tasks'] = $aTasks;
            $c0++;
        }
        // dd(['old request' => $oldReq ,'request' => $allReq, 'array miles' => $aMiles]);

        //compare with database and save
        $changes = false;
        $c0 = 0;
        foreach ($miles as $mile) {
            if (!$aMiles[$c0]['delete']
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
            elseif ($aMiles[$c0]['delete']){
                $mile->delete();
                $changes = true;
            }

            if (!$aMiles[$c0]['delete']){
                //compare tasks with database and save
                $c1 = 0;
                foreach ($mile->tasks as $task) {
                    if (!$aMiles[$c0]['tasks'][$c1]['delete']//problem: undefined array key 0
                    && ($task->name != $aMiles[$c0]['tasks'][$c1]['name'] || $task->done != $aMiles[$c0]['tasks'][$c1]['done'])){
                        $task->name = $aMiles[$c0]['tasks'][$c1]['name'];
                        $task->done = $aMiles[$c0]['tasks'][$c1]['done'];
                        $task->save();
                        $changes = true;
                    }
                    elseif ($aMiles[$c0]['tasks'][$c1]['delete']){
                        $task->delete();
                        $changes = true;
                    }
                    $c1++;
                }
                $key = $aMiles[$c0]['key'] . 'nt';
                for ($i = 1; $i <= 5;$i++){
                    $newTaskKey = $key . $i;
                    if (array_key_exists($newTaskKey,$allReq) && $allReq[$newTaskKey] != null){
                        $task = new Task;
                        $task->milestone_id = $mile->id;
                        $task->name = $allReq[$newTaskKey];
                        $task->done = false;
                        $task->save();
                    }
                }
            }
            $c0++;
        }
        //Add new milestones
        if ($allReq['new_mile'] != null){
            $mile = new Milestone;
            $mile->sub_project_id = $sub->id;
            $mile->name = $allReq['new_mile'];
            $mile->start_date = $allReq['new_mile_start'];
            $mile->end_date = $allReq['new_mile_end'];
            $mile->save();
        }

        if ($changes){
            $request->banner("Manager '" . Auth()->user()->name . "' change something (milesones & tasks) in sub project '" . $sub->name . "'",'s'
            ,null,Auth()->user()->id,$sub->big_project->id,$sub->id,$sub->big_project->PTJ);
        }
        return redirect()->route('edit.sub',$sub);
    }

    private function isExist(string $name,int $mileId, int $taskId = null, string $extra = null): bool
    {
        $toCompare = '';
        if ($taskId != null)
            $toCompare = $this->threeDigit('t',$mileId,$taskId);
        else
            $toCompare = $this->threeDigit('m',$mileId);

        if ($extra != null)
            $toCompare .= $extra;
        return $name == $toCompare;
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
