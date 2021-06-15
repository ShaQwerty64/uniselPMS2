<?php

namespace App\View\Components;

use App\Models\BigProject;
use Illuminate\View\Component;

class SubProjectRow extends Component
{
    public BigProject $big;
    public string $bigModalColor;
    public string $isPTJ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BigProject $big, string $bigModalColor, string $isPTJ)
    {
        $this->big = $big;
        $this->bigModalColor = $bigModalColor;
        $this->isPTJ = $isPTJ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sub-project-row');
    }
}
