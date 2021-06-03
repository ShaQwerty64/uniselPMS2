<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Http\Request;
use Livewire\Component;

class UpgradeProject extends Component
{
    public SubProject $subProj;
    public string $PTJ;
    public string $bigProjectName;
    public string $subProjectName;
    public string $oldName;

    protected $rules = [
        'bigProjectName' => 'required|unique:App\Models\BigProject,name',
        'subProjectName' => 'required',
    ];

    public function mount(){
        $this->oldName        = $this->subProj->name;
        $this->bigProjectName = $this->oldName;
        $this->subProjectName = $this->oldName;
    }

    public function upgrade(Request $request){
        $this->validate();
        $bigProj            = new BigProject;
        $bigProj->name      = $this->bigProjectName;
        $bigProj->details   = $this->subProj->details;
        $bigProj->PTJ       = $this->PTJ;
        $bigProj->start_date= $this->subProj->start_date;
        $bigProj->end_date  = $this->subProj->end_date;
        $bigProj->default   = false;
        $bigProj->save(); $bigProj->refresh();
        $bigProj->users()->saveMany($this->subProj->users);
        $this->subProj->name            = $this->subProjectName;
        $this->subProj->big_project_id  = $bigProj->id;
        $this->subProj->save();
        $request->session()->put('banner.m', $this->oldName . ' (sub) project upgraded to '
            . $this->bigProjectName . ' (big) project and old (sub) project rename to '
            . $this->subProjectName . '.');
        $request->session()->put('banner.t', 's');
        return redirect()->route('admin');
    }
    public function render()
    {
        return view('livewire.upgrade-project');
    }
}
