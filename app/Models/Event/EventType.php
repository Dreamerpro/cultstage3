<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table="event_types";

    public function event()
    {
    	return $this->hasOne('App\Event');
    }
}
