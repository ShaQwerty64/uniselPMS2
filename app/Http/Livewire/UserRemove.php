<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserRemove extends Component
{
    public $big;
    public $proj;
    public $name;
    public $htmlid;

    public function mount(){
        if ($this->big){
            $this->htmlid = 'modalbigprojremove' . $this->proj->id;
        }
        else{
            $this->htmlid = 'modalsubprojremove' . $this->proj->id;
        }
    }

    public function removeUser(int $id){
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->proj->id]);
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->proj->id]);
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
