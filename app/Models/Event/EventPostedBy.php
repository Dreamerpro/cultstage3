<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventPostedBy extends Model
{
    protected $table="event_posted_bies";

    public function poster()
    {
    	return $this->belongsToOne('App\User');
    }
    public function events()
    {
    	return $this->belongsToOne('App\Event');
    }
}
