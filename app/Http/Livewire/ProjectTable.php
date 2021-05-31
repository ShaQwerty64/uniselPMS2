<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Http\Request;
use Livewire\Component;

class ProjectTable extends Component
{
    public $bigProjects;
    public $projects;

    public function dd(){
        dd('Success!');
    }

    public function bigDelete(int $id, Request $request){
        $bigProject = BigProject::where('id',$id)->get()[0];
        $bigProject->delete();
        $request->session()->flash('banner.m', $bigProject->name . ' (big) project deleted.');
        $request->session()->flash('banner.t', '');
        return redirect()->route('admin');
    }

    public function subDelete(int $id, Request $request){
        $subProj = SubProject::where('id',$id)->get()[0];
        $subProj->delete();
        $request->session()->flash('banner.m', $subProj->name . ' (sub) project deleted.');
        $request->session()->flash('banner.t', '');
        return redirect()->route('admin');
    }

    public function render()
    {
        $this->bigProjects = BigProject::with(['sub_projects', 'users'])->orderBy('PTJ', 'asc')->get();
        return view('livewire.project-table');
    }
}
