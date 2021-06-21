<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Illuminate\Contracts\View\Factory;
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
        $request->banner("Admin '" . auth()->user()->name
            . "' upgrade sub project '"
            . $this->oldName . "', (sub) name its big project '"
            . $this->bigProjectName . "' and sub project '"
            . $this->subProjectName
            ,'s'
            ,auth()->user()->id
            ,null
            ,$bigProj->id
            ,$this->subProj->id
            ,$bigProj->PTJ
        );
        return redirect()->route('admin');
    }
    public function render()
    {
        return view('livewire.upgrade-project');
    }
}
