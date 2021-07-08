<?php

namespace App\View\Components;

use App\Models\SubProject;
use Illuminate\View\Component;

class ViewerSubProject extends Component
{
    public SubProject $sub;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SubProject $sub)
    {
        $this->sub = $sub;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.viewer-sub-project');
    }
}
