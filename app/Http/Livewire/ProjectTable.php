<?php

namespace App\Http\Livewire;

use App\Models\BigProject;
use Livewire\Component;

class ProjectTable extends Component
{
    public $bigProjects;
    public $projects;

    public function render()
    {
        $this->bigProjects = BigProject::with(['sub_projects', 'users'])->orderBy('PTJ', 'asc')->get();
        return view('livewire.project-table');
    }
}
