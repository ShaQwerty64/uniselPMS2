<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ProjectTable extends Component
{
    public Collection $PTJs;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $ptjs)
    {
        $this->PTJs = $ptjs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.project-table');
    }
}
