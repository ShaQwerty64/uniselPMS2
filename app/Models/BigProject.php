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
}
