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
        $this->PTJs = BigProject::with(['sub_projects', 'users'])->where('default',true)->get();
        $this->modalProj = SubProject::first();
    }

    public function dd(){
        return view('livewire.project-table');
        dd('Success!');
    }

    public function bigDelete(int $id, Request $request){
        $bigProject = BigProject::where('id',$id)->first();
        $bigProject->delete();
        $request->session()->put('banner.m', $bigProject->name . ' (big) project deleted.');
        $request->session()->put('banner.t', '');
        return redirect()->route('admin');
    }

    public function subDelete(int $id, Request $request){
        $subProj = SubProject::where('id',$id)->first();
        $subProj->delete();
        $request->session()->put('banner.m', $subProj->name . ' (sub) project deleted.');
        $request->session()->put('banner.t', '');
        return redirect()->route('admin');
    }

    public function render()
    {
        $this->bigProjects = BigProject::with(['sub_projects', 'users'])->orderBy('PTJ', 'asc')->get();
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
