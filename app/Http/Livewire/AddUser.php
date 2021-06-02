<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddUser extends Component
{
    public $is;

    public $search = '';
    public $searchEmail = '';
    public $users = [];
    public $highlightIndex = 0;
    public $active = false;
    public $ifRegistered = false;
    public $theUser;
    public $areUsers = [];

    public $roleName;
    public $word;
    public $word2;
    public $anAdminOrAviewer;

    public $data;
    public $big;// bool / BigProject if ($this->is == 'project')
    public $pId;
    public $proj;
    public $name;

    public function mount()
    {
        $this->areUsers = [];
        if ($this->is == 'admin'){
            $this->roleName = 'admin';
            $this->word = 'Become Admin';
            $this->word2 = 'Enter Registered User to Become Admin';
            $this->anAdminOrAviewer = 'an admin';
            $this->getEmailOfRedundantUser();
        }
        elseif ($this->is == 'viewer'){
            $this->roleName = 'topMan';
            $this->word = 'Become Viewer';
            $this->word2 = 'Enter Registered User to Become Viewer';
            $this->anAdminOrAviewer = 'a viewer';
            $this->getEmailOfRedundantUser();
        }
        elseif($this->is == 'manager'){
            $this->roleName = 'projMan';
            $this->word = 'Become Manager';
            $this->word2 = 'Enter Registered User to Become Project Manager';
            $this->managerTableMount();
            foreach ($this->proj->users as $user){
                $this->areUsers[] = $user->email;
            }
        }
        elseif ($this->is == 'project'){
            $this->word = 'Move Project';
            $this->word2 = 'Enter Big Project Name or PTJ to Move To';
            $this->areUsers[] = $this->big->id;
        }
    }

    private function getEmailOfRedundantUser(){
        foreach (User::role($this->roleName)->get() as $user)
        {
            $this->areUsers[] = $user->email;
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
        if ($this->big == null){
            $this->searchEmail = $this->users[$this->highlightIndex]->email;
        }
        $this->search = $this->users[$this->highlightIndex]->name;
        $this->resetX();
    }

    public function select($index)
    {
        if ($this->big == null){
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
        if ($this->is == 'project'){
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
        if ($this->ifRegistered == false){
            $this->active = true;
        }
    }

    public function madeRole(Request $request)
    {
        if ($this->is == 'manager'){
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
        else if ($this->is == 'project'){
            $this->proj->big_project_id = $this->theUser->id;
            $this->proj->save();
            $request->session()->put('banner.m', '"' . $this->proj->name . '" is now under ' . $this->theUser->name . '.');
            $request->session()->put('banner.t', 's');
            return redirect()->route('admin');
        }
        $this->theUser->assignRole($this->roleName);
        $request->session()->put('banner.m', '"' . $this->theUser->name . '" is now ' . $this->anAdminOrAviewer . '.');
        $request->session()->put('banner.t', 's');
        return redirect()->route('addadmin');
    }

    public function managerTableMount(){
        if ($this->big){// as bool
            $this->proj = BigProject::where('id',$this->pId)->first();
        }
        else{
            $this->proj = SubProject::where('id',$this->pId)->first();
        }
    }

    public function managerTableRender(){
        $this->data = [];
        foreach ($this->proj->users as $user){
            $confirm = "'" . $user->name . " removed from " . $this->name . ".'";
            $row = [];
            $row[] = $user->name;
            $row[] = $user->email;
            $row[] = $this->btnRemove($confirm, $user->id);
            $this->data[] = $row;
        }
    }

    private function btnRemove(string $confirm, int $id): string{
        return ' <button class="remove" title="Remove" wire:click="managerTableRemove(' . $id . ')" onclick="return alert(' . $confirm . ')">Remove</button>';
    }

    public function managerTableRemove(int $id){//remove manager from project
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
        if ($this->is == 'manager'){
            $this->mount();
            $this->managerTableRender();
        }

        if ($this->search != '' && $this->active)
        {
            if ($this->is == 'project'){
                $this->users = BigProject::
                whereNotIn('id', $this->areUsers)
                ->where('name', 'like', '%'.$this->search.'%')
                ->take(10)
                ->get();
            }
            else{
                $this->users = User::
                whereNotIn('email', $this->areUsers)
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->whereNotIn('email', $this->areUsers)
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
}
