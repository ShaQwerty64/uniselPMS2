<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class AddAdmin extends Component
{
    public $search = '';
    public $users = [];
    public $highlightIndex = 0;
    public $active = false;

    public $ifRegistered = false;
    public $theUser;

    public $areAdmins = [];

    public function mount()
    {
        foreach (User::role('admin')->get() as $admin)
        {
            $this->areAdmins[] = $admin->email;
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

    public function madeAdmin()
    {
        $this->theUser->assignRole('admin');
        return redirect()->route('addadmin');
    }

    public function render()
    {
        if ($this->search != '' && $this->active)
        {
            $this->users = User::
            whereNotIn('email', $this->areAdmins)
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->whereNotIn('email', $this->areAdmins)
            ->take(10)
            ->get();
        }

        if (!$this->users === [] && $this->users[0]->name == $this->search)
        {
            $this->resetX();
        }

        $this->ifRegistered();
        return view('livewire.add-admin');
    }
}
