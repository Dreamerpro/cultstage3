<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table="event_types";
    
    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
}
