<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function sub_project(){
        return $this->belongsTo(SubProject::class);
    }
}
