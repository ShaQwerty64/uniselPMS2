<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProject extends Model
{
    use HasFactory;

    public function big_project(){
        return $this->belongsTo(BigProject::class);
    }

    public function milestones(){
        return $this->hasMany(Milestone::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_sub_project_relationships');
    }
}
