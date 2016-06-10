<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    protected $table="user_events";
    protected $hidden = ['created_at','updated_at'];

    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
}
