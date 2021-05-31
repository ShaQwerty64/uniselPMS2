<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserRemove extends Component
{
    public $big;
    public $pId;
    public $name;

    public $data = [];
    public $htmlid;

    private $proj;

    public function mount(){
        if ($this->big){
            $this->proj = BigProject::where('id',$this->pId)->get()[0];
            $this->htmlid = 'modalbigprojremove' . $this->pId;
        }
        else{
            $this->proj = SubProject::where('id',$this->pId)->get()[0];
            $this->htmlid = 'modalsubprojremove' . $this->pId;
        }
    }

    public function removeUser(int $id){
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->pId]);
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->pId]);
        }
    }

    public function addUser(int $id){
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->pId]);
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->pId]);
        }
    }

    public function render()
    {
        // $this->mount();
        // $this->data = [];
        // foreach ($this->proj->users as $user){
        //     $confirm = "'Are you sure you want to remove " . $user->name . " from " . $this->name . " ?'";
        //     $row = [];
        //     $row[] = $user->name;
        //     $row[] = $user->email;
        //     $row[] = $this->btnRemove($confirm, $user->id);
        //     $this->data[] = $row;
        // }
        return view('livewire.user-remove');
    }

    // private function btnRemove(string $confirm, int $id): string{
    //     $btnDelete = ' <button class="remove" title="Remove" wire:click="removeUser(' . $id . ')" onclick="return confirm(' . $confirm . ')">Remove</button>';
    //     return $btnDelete;
    // }
}
