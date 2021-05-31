<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use App\Models\SubProject;
use App\Models\User;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class AddUser extends Component
{
    public $is;

    public $search = '';
    public $users = [];
    public $highlightIndex = 0;
    public $active = false;

    public $ifRegistered = false;
    public $theUser;
    public $areUsers = [];

    public $roleName;
    public $word;

    public $big;
    public $pId;
    public $name;

    public $proj;
    public $data;

    public function mount()
    {
        $this->areUsers = [];
        $con = true;
        if ($this->is == 'admin'){
            $this->roleName = 'admin';
            $this->word = 'Admin';
        }
        elseif ($this->is == 'viewer'){
            $this->roleName = 'topMan';
            $this->word = 'Viewer';
        }
        elseif($this->is == 'manager'){
            $this->roleName = 'projMan';
            if ($this->big){
                $this->proj = BigProject::where('id',$this->pId)->first();
            }
            else{
                $this->proj = SubProject::where('id',$this->pId)->first();
            }
            foreach ($this->proj->users as $user){
                $this->areUsers[] = $user->email;
            }
            $this->word = 'Manager';
            $con = false;
        }

        if ($con){
            foreach (User::role($this->roleName)->get() as $user)
            {
                $this->areUsers[] = $user->email;
            }
        }

    }

    public function click()
    {
        $this->active = true;
    }

    public function resetX()
    {
        $this->ifRegistered();

        $this->highlightIndex = 0;
        $this->active = false;
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
        $this->search = $this->users[$this->highlightIndex]->name;
        $this->resetX();
    }

    public function select($name)
    {
        $this->search = $name;
        $this->resetX();
    }

    public function ifRegistered()
    {
        $this->ifRegistered = false;
        foreach ($this->users as $user) {
            if ($user->name == $this->search)
            {
                $this->ifRegistered = true;
                $this->theUser = $user;
                if ($this->users->count() == 1){
                    $this->active = false;
                }
                break;
            }
        }
        if ($this->ifRegistered == false){
            $this->active = true;
        }
    }

    public function madeRole()
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
        $this->theUser->assignRole($this->roleName);
        return redirect()->route('addadmin');
    }

    public function render()
    {
        if ($this->is == 'manager'){
            $this->mount();
        }
        if ($this->search != '' && $this->active)
        {
            $this->users = User::
            whereNotIn('email', $this->areUsers)
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->whereNotIn('email', $this->areUsers)
            ->take(10)
            ->get();
        }

        if (!$this->users === [] && $this->users[0]->name == $this->search)
        {
            $this->resetX();
        }

        $this->ifRegistered();
        return view('livewire.add-user');
    }
}
