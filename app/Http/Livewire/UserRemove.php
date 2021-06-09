<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use Livewire\Component;

class UserRemove extends Component
{
    public BigProject|SubProject $proj;
    public string $name;
    public string $htmlid;

    public function mount(){
        if ($this->proj instanceof BigProject){
            $this->htmlid = 'modalbigprojremove' . $this->proj->id;
        }
        else{
            $this->htmlid = 'modalsubprojremove' . $this->proj->id;
        }
    }

    public function reloadPage(){
        return redirect()->route('admin');
    }

    public function render()
    {
        return view('livewire.user-remove');
    }
}
