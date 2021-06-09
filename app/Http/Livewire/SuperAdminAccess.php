<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class SuperAdminAccess extends Component
{
    public function render()
    {
        return view('livewire.super-admin-access');
    }

    public function gainSuperAdminAccess(){
        Auth()->user()->assignRole('super-admin');
    }
}
