<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsHistory extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects_historys';

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

    // public function save_banner(){

    //     $this->admin_id = $this->admin_id == null ? 0: $this->admin_id;
    //     $this->user_id  = $this->user_id == null ? 0: $this->user_id;
    //     $this->big_project_id = $this->big_project_id == null ? 0: $this->big_project_id;
    //     $this->sub_project_id = $this->sub_project_id == null ? 0: $this->sub_project_id;
    //     $this->save();
    // }
}
