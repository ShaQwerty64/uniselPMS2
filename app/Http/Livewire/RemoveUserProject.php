<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveUserProject extends Component
{
    public User $user;

    public array $heads;
    public array $config;
    public array $toRemoveBig = [];
    public array $toRemoveSub = [];

    public function mount(){
        $this->heads = [ //for project manager adminLTE-datatable
            'Project Name',
            'Project Type',
            'PTJ',
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];
        foreach ($this->user->big_projects as $big){
            $this->toRemoveBig[] = false;
        }
        foreach ($this->user->sub_projects as $sub){
            $this->toRemoveSub[] = false;
        }
    }

    public function render()
    {
        $data = []; $count = 0;
        foreach ($this->user->big_projects as $big){
            $row = [];
            $row[] = $big->name;
            $row[] = 'Big';
            $row[] = $big->PTJ;
            $row[] = $this->removeBtn(true,$count);
            $data[] = $row;
            $count++;
        }
        $count = 0;
        foreach ($this->user->sub_projects as $sub){
            $row = [];
            $row[] = $sub->name;
            $row[] = 'Sub';
            $row[] = $sub->big_project->PTJ;
            $row[] = $this->removeBtn(false,$count);
            $data[] = $row;
            $count++;
        }
        $this->config = [ //for adminLTE-datatable
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];
        return view('livewire.remove-user-project');
    }

    private function removeBtn(bool $isBig = false ,int $indexToRemove = 0): string{
        $isToRemove = false; $isBigWord = '';
        if ($isBig){
            $isToRemove = $this->toRemoveBig[$indexToRemove];
            $isBigWord = 'true';
        }
        else{
            $isToRemove = $this->toRemoveSub[$indexToRemove];
            $isBigWord = 'false';
        }
        $word = 'Remove';
        if ($isToRemove){
            $word = 'Cancel';
        }
        return '<button class="remove" title="Remove" wire:click="togle(' . $isBigWord . ' ,' . $indexToRemove . ')" >' . $word . '</button>';
    }

    public function togle(bool $isBig = false ,int $indexToRemove = 0){
        if ($isBig){
            $this->toRemoveBig[$indexToRemove] = !$this->toRemoveBig[$indexToRemove];
            return;
        }
        $this->toRemoveSub[$indexToRemove] = !$this->toRemoveSub[$indexToRemove];
    }

    public function confirm(Request $request){
        $count = 0;
        foreach ($this->user->big_projects as $big){
            if ($this->toRemoveBig[$count]){
                DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$this->user->id,$big->id]);
                $request->banner("Admin '"
                . auth()->user()->name
                . "' remove user '"
                . $this->user->name
                . "' from big project '"
                . $big->name . "'"
                , ''
                , auth()->user()->id
                , $this->user->id
                , $big->id
                , null
                , $big->PTJ
                );
            }
            $count++;
        }
        $count = 0;
        foreach ($this->user->sub_projects as $sub){
            if ($this->toRemoveSub[$count]){
                DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$this->user->id,$sub->id]);
                $request->banner("Admin '"
                . auth()->user()->name
                . "' remove user '"
                . $this->user->name
                . "' from sub project '"
                . $sub->name . "'"
                , ''
                , auth()->user()->id
                , $this->user->id
                , $sub->big_project->id
                , $sub->id
                , $sub->big_project->PTJ
                );
            }
            $count++;
        }
        if ($this->user->sub_projects()->count() + $this->user->big_projects()->count() == 0){
            $this->user->removeRole('projMan');
            $request->banner("User '" . $this->user->name . "' no longer a project manager . . ."
            , '.'
            , auth()->user()->id
            , $this->user->id
            );
        }
        return redirect()->route('addadmin');
    }
}
