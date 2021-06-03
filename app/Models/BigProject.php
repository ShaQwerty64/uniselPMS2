<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigProject extends Model
{
    use HasFactory;

    public $PTJbigProjects;
    public $notHaveBig;
    public $projectsCount;
    public $projectsCount2;

    private $subCount;
    private $bigCount;

    public function sub_projects(){
        return $this->hasMany(SubProject::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_big_project_relationships');
    }

    public function milestones(){
        return $this->hasManyThrough(Milestone::class, SubProject::class);
    }

    public function PTJactive(){
        if ($this->default){
            $this->PTJbigProjects   = $this->PTJbigProjects();

            $this->subCount         = $this->sub_projects->count();
            $this->bigCount         = $this->PTJbigProjects->count();

            $this->notHaveBig       = $this->bigCount == 0;
            $this->projectsCount    = $this->projectsCount();
            $this->projectsCount2   = $this->subCount + $this->bigCount;
        }
    }

    private function PTJbigProjects(){
        return BigProject::with(['sub_projects', 'users'])->where('default',false)->where('PTJ',$this->PTJ)->get();
    }

    private function projectsCount(): int{
        $count = $this->subCount;
        foreach ($this->PTJbigProjects as $bigProj) {
            $count += $bigProj->sub_projects->count();
        }
        return $count;
    }
}
