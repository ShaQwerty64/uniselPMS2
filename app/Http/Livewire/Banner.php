<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class Banner extends Component
{
    public $message = '';
    public $theme = '';

    public function render(Request $request)
    {
        $this->message = $request->session()->get('banner.m', '');
        $this->theme = $request->session()->get('banner.t', '');
        $request->session()->forget(['banner.m','banner.t']);
        return view('livewire.banner');
    }
}
