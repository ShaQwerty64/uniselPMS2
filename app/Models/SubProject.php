<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProject extends Model
{
    use HasFactory;

    public function big_project(){
        return $this->belongsTo(BigProject::class,'big_project_id','id');
    }

    public function milestones(){
        return $this->hasMany(Milestone::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_sub_project_relationships');
    }

    public function tasks(){
        return $this->hasManyThrough(Task::class, Milestone::class);
    }

    public function historys(){
        return $this->hasMany(ProjectsHistory::class);
    }
}
