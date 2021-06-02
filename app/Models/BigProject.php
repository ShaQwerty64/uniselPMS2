<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigProject extends Model
{
    use HasFactory;

    public function sub_projects(){
        return $this->hasMany(SubProject::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_big_project_relationships');
    }

    public function notHaveBig(){
        if ($this->default){
            return BigProject::where('default',false)->where('PTJ',$this->PTJ)->count() == 0;
        }
        return true;
    }

    public function PTJbigProjects(){
        if ($this->default){
            return BigProject::with(['sub_projects', 'users'])->where('default',false)->where('PTJ',$this->PTJ)->get();
        }
        return false;
    }

    public function PTJsubProjects(){
        if ($this->default){
            return SubProject::with(['users'])->where('default',false)->where('PTJ',$this->PTJ)->get();
        }
        return false;
    }
}
