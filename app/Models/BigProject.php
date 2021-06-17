<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigProject extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class,'user_big_project_relationships');
    }
    public function sub_projects(){
        return $this->hasMany(SubProject::class);
    }

    public function milestones(){
        return $this->hasManyThrough(Milestone::class, SubProject::class);
    }

    public function historys(){
        return $this->hasMany(ProjectsHistory::class);
    }

    public int $tasks_count = 0;
    public int $done_tasks_count = 0;

    public function tasksCount(){
        $this->tasks_count = 0;
        $this->done_tasks_count = 0;
        $this->milestones->loadCount([
            'tasks',
            'tasks as done_tasks_count' => function ($query){
                $query->where('done', false);
            }
        ]);
        foreach($this->milestones as $milestone){
            $this->tasks_count += $milestone->tasks_count;
            $this->done_tasks_count += $milestone->done_tasks_count;
        }
    }

    //PTJ things
    public Collection $PTJbigProjects;
    public bool $notHaveBig = false;
    public int $projectsCount;
    public int $projectsCount2;

    private $subCount;
    public $bigCount;

    // public function PTJs(){
    //     $PTJs = BigProject::
    //     with(['sub_projects', 'sub_projects.users'])
    //     ->withCount(['milestones'])
    //     ->where('default',true)
    //     ->get();
    //     foreach ($this->PTJs as $PTJ){
    //         $PTJ->PTJactive();
    //     }
    //     return $PTJs;
    // }

    public function PTJactive(){
        if ($this->default){
            $this->PTJbigProjects();
            $this->subCount         = $this->sub_projects->count();
            $this->bigCount         = $this->PTJbigProjects->count();

            $this->notHaveBig       = $this->bigCount == 0;
            $this->projectsCount    = $this->projectsCount();
            $this->projectsCount2   = $this->subCount + $this->bigCount;
        }
    }

    public function PTJmilestonesCount(): int{
        $count = 0;
        foreach ($this->PTJbigProjects as $big){
            $count += $big->milestones_count;
        }
        return $count;
    }

    private function PTJbigProjects(){
        $this->PTJbigProjects = BigProject::
        with(['sub_projects', 'sub_projects.users:id,name,email' , 'users:id,name,email'])
        ->withCount(['milestones'])
        ->where('default',false)
        ->where('PTJ',$this->PTJ)
        ->get();

        $this->sub_projects->loadCount([
            'tasks',
            'tasks as done_tasks_count' => function ($query){
                $query->where('done', false);
            },
            'milestones',
        ]);

        $this->tasks_count = 0;
        $this->done_tasks_count = 0;
        foreach ($this->sub_projects as $sub){
            $this->tasks_count += $sub->tasks_count;
            $this->done_tasks_count += $sub->done_tasks_count;
        }

        foreach ($this->PTJbigProjects as $big){
            $big->sub_projects->loadCount([
                'tasks',
                'tasks as done_tasks_count' => function ($query){
                    $query->where('done', false);
                },
                'milestones',
            ]);

            foreach ($big->sub_projects as $sub){
                $big->tasks_count += $sub->tasks_count;
                $big->done_tasks_count += $sub->done_tasks_count;
            }

            $this->tasks_count += $big->tasks_count;
            $this->done_tasks_count += $big->done_tasks_count;
        }
    }

    private function projectsCount(): int{
        $count = $this->subCount;
        foreach ($this->PTJbigProjects as $bigProj) {
            $count += $bigProj->sub_projects->count();
        }
        return $count;
    }
}
