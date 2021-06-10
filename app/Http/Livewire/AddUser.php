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
    public array $redundant = [];//
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
            $this->anAdminOrAviewer = 'an admin';
        }
        //search user to become viewer
        elseif ($this->isViewer){
            $this->roleName = 'topMan';
            $this->word = 'Become Viewer';
            $this->word2 = 'Enter Registered User to Become Viewer';
            $this->anAdminOrAviewer = 'a viewer';
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
        if ($this->isProject){
            $this->word = 'Move Project';
            $this->word2 = 'Enter Big Project Name or PTJ to Move To';
            $this->redundant[] = $this->big->id;
        }
        else{
            $this->getIdOfRedundantUser();
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
                $this->users = User::
                whereNotIn('id', $this->redundant)
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->whereNotIn('email', $this->redundant)
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
        $this->redundant = [];
        if ($this->isManager){
            foreach ($this->proj->users as $user){
                $this->redundant[] = $user->id;
            }
            return;
        }
        foreach (User::role($this->roleName)->get() as $user){
            $this->redundant[] = $user->id;
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
            $this->theUser->assignRole($this->roleName);
            if ($this->big){
                $this->theUser->big_projects()->save($this->proj);
            }
            else{
                $this->theUser->sub_projects()->save($this->proj);
            }
            $this->search = '';
            return;// redirect()->route('admin')
        }
        else if ($this->isProject){
            $this->proj->big_project_id = $this->theUser->id;
            $this->proj->save();
            $request->banner('"' . $this->proj->name . '" is now under ' . $this->theUser->name . '.','s');
            return redirect()->route('admin');
        }
        $this->theUser->assignRole($this->roleName);
        $request->banner('"' . $this->theUser->name . '" is now ' . $this->anAdminOrAviewer . '.', 's');
        return redirect()->route('addadmin');
    }

    public function managerTableRemove(int $id){//remove manager from project
        if ($this->big){
            DB::delete('delete from user_big_project_relationships where user_id = ? and big_project_id = ?', [$id,$this->proj->id]);
        }
        else{
            DB::delete('delete from user_sub_project_relationships where user_id = ? and sub_project_id = ?', [$id,$this->proj->id]);
        }
        $user = User::where('id',$id)->first();
        if ($user->sub_projects()->count() + $user->big_projects()->count() == 0){
            $user->removeRole('projMan');
        }
    }
}
