<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
     protected $table="event_locations";

    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
}
