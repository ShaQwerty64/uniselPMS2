<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Http\Request;
use Livewire\Component;

class ProjectTable extends Component
{
    public $PTJs;

    public function mount(){
        $this->PTJs = BigProject::
        with(['sub_projects', 'sub_projects.users'])
        ->withCount(['milestones'])
        ->where('default',true)
        ->get();
        foreach ($this->PTJs as $PTJ){
            $PTJ->PTJactive();
            // dd($PTJ);
        }
    }

    public function dd(){
        dd($this);
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
            $request->session()->put('banner.m', $big->name . ' (big) project and all its sub projects deleted.');
        }
        else{
            $PTJ = $this->findPTJ($big->PTJ)->id;
            foreach ($big->sub_projects as $sub) {
                $sub->big_project_id = $PTJ;
                $sub->save();
            }
            $big->delete();
            $request->session()->put('banner.m', $big->name . ' (big) project deleted and all its sub projects move to ' . $big->PTJ . ' Default.');
        }
        $request->session()->put('banner.t', '');
        return redirect()->route('admin');
    }

    public function subDelete(SubProject $sub, Request $request){
        $sub->delete();
        $request->session()->put('banner.m', $sub->name . ' (sub) project deleted.');
        $request->session()->put('banner.t', '');
        return redirect()->route('admin');
    }

    public function render()
    {
        return view('livewire.project-table');
    }
}
    // public $modalProj;
    // public $isBig;
    // public $modalName = 'Loding . . .';
    // public $modalColor = '';
    // public $modalBigProj;
    // public $modalActive = false;
    // public function projDelete(Request $request){
    //     $this->modalProj->delete();
    //     $bigOrSub = 'sub';
    //     if ($this->isBig){ $bigOrSub = 'big'; }
    //     $request->session()->put('banner.m', $this->modalProj->name . ' (' . $bigOrSub . ') project deleted.');
    //     $request->session()->put('banner.t', '');
    //     return redirect()->route('admin');
    // }

    // public function setModal(bool $isBig, $projId, string $name, string $color, $bigProjId){
    //     $this->modalActive = true;
    //     $this->isBig = $isBig;
    //     $this->modalName = $name;
    //     $this->modalColor = $color;
    //     if ($isBig){
    //         $this->modalProj = BigProject::where('id',$projId)->first();
    //         return;
    //     }
    //     $this->modalProj = SubProject::where('id',$projId)->first();
    //     $this->modalBigProj = BigProject::where('id',$bigProjId)->first();
    // }

    // public function offModal(){
    //     $this->modalActive = false;
    // }
