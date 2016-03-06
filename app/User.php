<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function phone()
    {
        return $this->hasOne('App\Models\User\UserPhone');
    }
    public function dob()
    {
        return $this->hasOne('App\Models\User\UserDOB');
    }
    public function languages()
    {
        return $this->hasMany('App\Models\User\UserLanguage');
    }
    public function locations()
    {
        return $this->hasMany('App\Models\User\UserLocation');
    }
    public function roles()
    {
        return $this->hasMany('App\Models\User\UserRole');
    }

    public function connections()
    {
        return $this->hasMany('App\Models\User\UserConnection');
    }

    public function bookmarked_events()
    {
        return $this->hasMany('App\Models\User\UserEvent');
    }
    public function posted_events()
    {
        return $this->hasMany('App\Models\Event\EventPostedBy');
    }

    public function my_projects()
    {
        return $this->hasMany('App\Project');
    }
    
    public function job_postings()
    {
        return $this->hasMany('App\Job','posted_by');
    }

    public function applied_jobs()
    {
        return $this->hasMany('App\Models\User\UserJob');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
}
