<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class Banner extends Component
{
    public string $message;
    public string $theme;

    public function render(Request $request)
    {
        $this->message = $request->session()->get('banner.m', '');
        $this->theme = $request->session()->get('banner.t', '');
        $request->session()->forget(['banner.m','banner.t']);
        return view('livewire.banner');
    }
}
