<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddUser extends Component
{
    public bool $isAdmin = false; public bool $isViewer = false; public bool $isManager = false; public bool $isProject = false;
    public null|BigProject|SubProject $proj;
    public null|bool|BigProject $big;// if ($this->isProject) BigProject
    public null|string $name;

    public string $search = '';//
    public string $searchEmail = '';//
    public $users = [];// Collection
    public array $redundant = [];
    public array $redundantE = [];
    public int $highlightIndex = 0;//
    public User|BigProject|SubProject $theUser;//
    public bool $ifRegistered = false;//
    public bool $active = false;//

    public string $roleName;//
    public string $word;//
    public string $word2;//
    public string $anAdminOrAviewer = '';//

    public array $heads;
    public array $config;

    public function mount()
    {
        //search user to become admin
        if ($this->isAdmin){
            $this->roleName = 'admin';
            $this->word = 'Become Admin';
            $this->word2 = 'Enter Registered User to Become Admin';
            $this->anAdminOrAviewer = 'admin';
        }
        //search user to become viewer
        elseif ($this->isViewer){
            $this->roleName = 'topMan';
            $this->word = 'Become Viewer';
            $this->word2 = 'Enter Registered User to Become Viewer';
            $this->anAdminOrAviewer = 'viewer';
        }
        //search user to become project manager
        elseif($this->isManager){
            $this->roleName = 'projMan';
            $this->word = 'Become Manager';
            $this->word2 = 'Enter Registered User to Become Project Manager';
            $this->big = $this->proj instanceof BigProject;
            $this->heads = [ //for project manager adminLTE-datatable
                'Name',
                ['label' => 'Email', 'width' => 40],
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];
        }
        //search big project to move the sub project to
        elseif ($this->isProject){
            $this->word = 'Move Project';
            $this->word2 = 'Enter Big Project Name or PTJ to Move To';
            $this->redundant[] = $this->big->id;
        }
    }

    public function render()
    {
        if ($this->isManager){
            $this->managerTableRender();
        }
        if ($this->search != '' && $this->active)
        {
            if ($this->isProject){
                $this->users = BigProject::
                whereNotIn('id', $this->redundant)
                ->where('name', 'like', '%'.$this->search.'%')
                ->take(10)
                ->get();
            }
            else{
                $this->getIdOfRedundantUser();
                $this->users = User::
                whereNotIn('id', $this->redundant)
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->whereNotIn('email', $this->redundantE)
                ->take(10)
                ->get();
            }
        }
        if (!$this->users === [] && $this->users[0]->name == $this->search)
        {
            $this->resetX();
        }

        $this->ifRegistered();
        return view('livewire.add-user');
    }

    public function managerTableRender(){
        $data = [];
        foreach ($this->proj->users as $user){
            $confirm = "'" . $user->name . " removed from " . $this->name . ".'";
            $row = [];
            $row[] = $user->name;
            $row[] = $user->email;
            $row[] = $this->btnRemove($confirm, $user->id);
            $data[] = $row;
        }
        $this->config = [ //for project manager adminLTE-datatable
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];
    }

    private function btnRemove(string $confirm, int $id): string{
        return '<button class="remove" title="Remove" wire:click="managerTableRemove(' . $id . ')" onclick="return alert(' . $confirm . ')">Remove</button>';
    }

    private function getIdOfRedundantUser(){
        $this->redundant = []; $this->redundantE = [];
        foreach ($this->isManager ? $this->proj->users
        : User::role($this->roleName)->get() as $user){
            $this->redundant[] = $user->id;
            $this->redundantE[] = $user->id;
        }
    }

    public function click()
    {
        $this->active = true;
    }

    public function highlightDown()
    {
        if ($this->highlightIndex + 1 < count($this->users))
        {
            $this->highlightIndex++;
            return;
        }
        $this->highlightIndex = 0;
    }

    public function highlightUp()
    {
        if ($this->highlightIndex != 0)
        {
            $this->highlightIndex--;
            return;
        }
        $this->highlightIndex = count($this->users) - 1;
    }

    public function selectEnter()
    {
        if (!$this->isProject){
            $this->searchEmail = $this->users[$this->highlightIndex]->email;
        }
        $this->search = $this->users[$this->highlightIndex]->name;
        $this->resetX();
    }

    public function select($index)
    {
        if (!$this->isProject){
            $this->searchEmail = $this->users[$index]->email;
        }
        $this->search = $this->users[$index]->name;
        $this->resetX();
    }

    public function resetX()
    {
        $this->ifRegistered();
        $this->highlightIndex = 0;
        $this->active = false;
    }

    public function ifRegistered()
    {
        $this->ifRegistered = false;
        if ($this->isProject){
            foreach ($this->users as $proj) {
                if ($proj->name == $this->search)
                {
                    $this->ifRegistered = true;
                    $this->theUser = $proj;
                    if ($this->users->count() == 1){
                        $this->active = false;
                    }
                    break;
                }
            }
        }
        else{
            foreach ($this->users as $user) {
                if ($user->email == $this->searchEmail)
                {
                    $this->ifRegistered = true;
                    $this->theUser = $user;
                    if ($this->users->count() == 1){
                        $this->active = false;
                    }
                    break;
                }
            }
        }
        if (!$this->ifRegistered){
            $this->active = true;
        }
    }

    public function madeRole(Request $request)
    {
        if ($this->isManager){
            if ($this->big){
                $this->theUser->big_projects()->save($this->proj);
                $request->banner("Admin '" . auth()->user()->name
                .  "' add user '" . $this->theUser->name
                . "' to big project '" . $this->proj->name
                . "' (" . $this->proj->PTJ . ")"
                , '.'
                , auth()->user()->id
                , $this->theUser->id
                , $this->proj->id
                , null
                , $this->proj->PTJ
                );
            }
            else{
                $this->theUser->sub_projects()->save($this->proj);
                $request->banner("Admin '" . auth()->user()->name
                .  "' add user '" . $this->theUser->name
                . "' to sub project '" . $this->proj->name
                . "' (" . $this->proj->big_project->PTJ . ")"
                , '.'
                , auth()->user()->id
                , $this->theUser->id
                , $this->proj->big_project->id
                , $this->proj->id
                , $this->proj->big_project->PTJ
                );
            }
            if (!$this->theUser->hasAnyRole('projMan')){
                $this->theUser->assignRole('projMan');
                $request->banner("User '" . $this->theUser->name . "' now a project manager!", '.',auth()->user()->id,$this->theUser->id);
            }
            $this->search = '';
            return;// redirect()->route('admin')
        }
        else if ($this->isProject){
            $old = $this->proj->big_project;
            $this->proj->big_project_id = $this->theUser->id;
            $this->proj->save();
            $message = "Admin '"
            . auth()->user()->name
            .  "' move sub project '"
            . $this->proj->name . "' from big project '"
            . $old->name
            . "' (" . $old->PTJ . ") into big project '"
            . $this->theUser->name . "' ("
            . $this->theUser->PTJ . ")";
            $request->banner($message, ''
            , auth()->user()->id
            ,null
            ,$this->theUser->id
            ,$this->proj->id
            ,$this->theUser->PTJ
            ,$old->id
            ,$old->PTJ);
            return redirect()->route('admin');
        }
        $this->theUser->assignRole($this->roleName);
        $request->banner("Admin '" . auth()->user()->name .  "' give user '" . $this->theUser->name . "' " . $this->anAdminOrAviewer . " role",'',auth()->user()->id,$this->theUser->id);
        return redirect()->route('addadmin');
    }

    public function managerTableRemove(int $id, Request $request){//remove manager from project
        $user = User::where('id',$id)->first();
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->proj->id]);
            $request->banner("Admin '"
                . auth()->user()->name
                . "' remove user '"
                . $user->name
                . "' from big project '"
                . $this->proj->name . "'"
                , '.'
                , auth()->user()->id
                , $user->id
                , $this->proj->id
                , null
                , $this->proj->PTJ
                );
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->proj->id]);
            $request->banner("Admin '"
            . auth()->user()->name
            . "' remove user '"
            . $user->name
            . "' from sub project '"
            . $this->proj->name . "'"
            , '.'
            , auth()->user()->id
            , $user->id
            , $this->proj->big_project->id
            , $this->proj->id
            , $this->proj->big_project->PTJ
            );
        }
        if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
            $user->removeRole('projMan');
            $request->banner("User '" . $user->name . "' no longer a project manager . . ."
            , '.'
            , auth()->user()->id
            , $user->id
            );
        }
    }
}
