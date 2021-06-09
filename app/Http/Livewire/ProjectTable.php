<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;

class ProjectTable extends Component
{
    public Collection $PTJs;

    public function mount(){
        $this->PTJs = BigProject::
        with(['sub_projects', 'sub_projects.users:id,name,email'])
        ->withCount(['milestones'])
        ->where('default',true)
        ->get(['id','name','PTJ','details']);
        foreach ($this->PTJs as $PTJ){
            $PTJ->PTJactive();
        }
    }

    private function findPTJ(string $PTJPTJ): BigProject{
        foreach ($this->PTJs as $PTJ) {
            if ($PTJ->PTJ == $PTJPTJ){
                return $PTJ;
            }
        }
    }

    public function bigDelete(BigProject $big, bool $deleteAll, Request $request){
        if ($deleteAll){
            $big->delete();
            $request->banner($big->name . ' (big) project and all its sub projects deleted.');
        }
        else{
            $PTJ = $this->findPTJ($big->PTJ)->id;
            foreach ($big->sub_projects as $sub) {
                $sub->big_project_id = $PTJ;
                $sub->save();
            }
            $big->delete();
            $request->banner($big->name . ' (big) project deleted and all its sub projects move to ' . $big->PTJ . ' Default.');
        }
        return redirect()->route('admin');
    }

    public function subDelete(SubProject $sub, Request $request){
        $sub->delete();
        $request->banner($sub->name . ' (sub) project deleted.');
        return redirect()->route('admin');
    }

    public function reloadPage(){
        return redirect()->route('admin');
    }

    public function render()
    {
        return view('livewire.project-table');
    }
}
