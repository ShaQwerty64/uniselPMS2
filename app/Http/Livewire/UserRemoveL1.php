<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserRemoveL1 extends Component
{
    public $data;
    public $big;
    public $pId;
    public $name;

    public function mount(){
        if ($this->big){
            $this->proj = BigProject::where('id',$this->pId)->get()[0];
        }
        else{
            $this->proj = SubProject::where('id',$this->pId)->get()[0];
        }
    }

    public function removeUser(int $id){
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->pId]);
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->pId]);
        }
        $user = User::where('id',$id)->first();
        if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
            $user->removeRole('projMan');
        }
    }

    public function render()
    {
        $this->mount();
        $this->data = [];
        foreach ($this->proj->users as $user){
            $confirm = "'" . $user->name . " removed from " . $this->name . ".'";
            $row = [];
            $row[] = $user->name;
            $row[] = $user->email;
            $row[] = $this->btnRemove($confirm, $user->id);
            $this->data[] = $row;
        }
        return view('livewire.user-remove-l1');
    }

    private function btnRemove(string $confirm, int $id): string{
        $btnDelete = ' <button class="remove" title="Remove" wire:click="removeUser(' . $id . ')" onclick="return alert(' . $confirm . ')">Remove</button>';
        return $btnDelete;
    }
}
