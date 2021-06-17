<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminlte_image()
    {
        $gravatar = md5( strtolower( trim( $this->email)));
        return 'https://www.gravatar.com/avatar/'.$gravatar.'?s=200';
    }

    public function adminlte_desc()
    {
        return 'That\'s a nice guy';
    }

    public function sub_projects(){
        return $this->belongsToMany(SubProject::class,'user_sub_project_relationships');
    }

    public function big_projects(){
        return $this->belongsToMany(BigProject::class,'user_big_project_relationships');
    }

    public function admin_historys(){
        return $this->hasMany(ProjectsHistory::class,'admin_id');
    }

    public function user_historys(){
        return $this->hasMany(ProjectsHistory::class,'user_id');
    }
}
