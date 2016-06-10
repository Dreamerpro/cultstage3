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
        'password', 'remember_token', 'pivot','connections_iaccepted', 'connections_irequested'
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
        //return $this->hasMany('App\Models\User\UserLanguage');
        return $this->belongsToMany('App\Models\Detail\Language','user_languages');
    }
    public function locations()
    {
        return $this->belongsToMany('App\Models\Detail\Location','user_locations');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Detail\Roles','user_roles','user_id','role_id');
    }

    public function connections_accepted()//accepted connections
    {
          return $this->connections_iaccepted->merge($this->connections_irequested);
    }

    public function connections_iaccepted()//accepted connections **used by connections_accepted
    {
          return $this->belongsToMany('App\User','user_connections','user_id1','user_id2')->wherePivot('status', 1);
    }
    public function connections_irequested()//accepted-requested connections **used by connections_accepted
    {
          //return $this->hasMany('App\Models\User\UserConnection');
          return $this->belongsToMany('App\User','user_connections','user_id2','user_id1')->wherePivot('status', 1);
    }
    public function connect_requests()//all not interacted requests for me //
    {
        return $this->belongsToMany('App\User','user_connections','user_id2','user_id1')->wherePivot('status', 0);
    }
    public function connection_status($user)
    {
      if(!\Auth::user()){return false;}
      return \App\Models\User\UserConnection::where('user_id2',$this->id)->where('user_id1',$user->id)->first() ?\App\Models\User\UserConnection::where('user_id2',$this->id)->where('user_id1',$user->id)->first(): \App\Models\User\UserConnection::where('user_id2',$user->id)->where('user_id1',$this->id)->first();
    }
    public function all_connect_requests()//whole/all requests for me
    {
        return $this->belongsToMany('App\User','user_connections','user_id2','user_id1');
    }

    public function bookmarked_events()
    {
        //return $this->hasMany('App\Models\User\UserEvent');
        return $this->belongsToMany('App\Event','user_events','user_id','event_id');
    }
    public function posted_events()
    {
        return $this->hasMany('App\Event','postedby','id');
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
      //return $this->hasMany('App\Models\User\UserJob');
      return $this->belongsToMany('App\Job','applied_jobs','user_id','job_id');
    }
    public function videos()
    {
        return $this->hasMany('App\Video');
    }
    public function audios()
    {
        return $this->hasMany('App\Audio');
    }
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function scripts()
    {
        return $this->hasMany('App\Script');
    }
    public function images()
    {
        return $this->hasMany('App\Image');
    }

}
