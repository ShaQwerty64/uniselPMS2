<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsHistory extends Model
{
    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function big_project()
    {
        return $this->belongsTo(BigProject::class);
    }

    public function sub_project()
    {
        return $this->belongsTo(SubProject::class);
    }
}
