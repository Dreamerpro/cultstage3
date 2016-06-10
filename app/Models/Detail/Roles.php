<?php

namespace App\Models\Detail;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table="roles";
    protected $hidden = ['created_at','updated_at','pivot'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function events()//audience of event
    {
      return $this->belongsToMany('App\Event','event_audiences','role_id','event_id');//->hasMany('App\Models\Event\EventAudience');
    }
}
