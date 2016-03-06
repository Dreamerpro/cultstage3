<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLanguage extends Model
{
     protected $table="event_languages";

    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
    public function languages()
    {
    	return $this->belongsToMany('App\Models\Detail\Language');
    }
}
