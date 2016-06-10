<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Detail\Language;
use App\Models\Detail\Location;
use App\Models\Event\EventAudience;

class Event extends Model
{
	  use SoftDeletes;
    protected $table='events';
		protected $dates = ['deleted_at'];
    protected $hidden = ['pivot','created_at','updated_at','postedby'];

	public function languages()
    {
        return $this->belongsToMany('App\Models\Detail\Language','event_languages');
    }
    public function locations()
    {
        return $this->belongsToMany('App\Models\Detail\Location','event_locations');
    }
    public function audiences()
    {
        return $this->belongsToMany('App\Models\Detail\Roles','event_audiences','event_id','role_id');//->hasMany('App\Models\Event\EventAudience');
    }
    public function organizer()
    {
        return $this->hasMany('App\Models\Event\EventOrganizer');
    }
    public function postedby()
    {
        return $this->belongsTo('App\User','postedby','id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\Event\EventType');
    }

    public static function getalldetails($arrayofids)
    {
        $events_collection=[];
        foreach ($arrayofids as $arrayofid) {
            $event=Event::find($arrayofid->event_id);
						if($event){
							// $event->nlanguages=Language::getAllLanguages($event->languages->implode('language_id',","));
							// $event->nlocations=Location::getAllLocations($event->locations->implode('location_id',","));
							// $event->naudience=EventAudience::getAllAudiences($event->audience->implode('role_id',","));
							$event->languages;
							$event->locations;
							$event->audience;
							$zz=collect($event);
							// ->except(['created_at','updated_at','deleted_at'])
							// 		->merge(['languages'=>explode(',',$event->nlanguages->implode('language',','))])
							// 		->merge(['locations'=>explode(',',$event->nlocations->implode('location',','))])
							// 		->merge(['audience'=>explode(',',$event->naudience->implode('name',','))]);
									// $event->alanguages=
								//	dd($event->languages);
							array_push($events_collection, $zz);
						}

        }

        return $events_collection;
    }

}
