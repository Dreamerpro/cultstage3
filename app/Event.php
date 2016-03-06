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

	public function languages()
    {
        return $this->hasMany('App\Models\Event\EventLanguage');
    }
    public function locations()
    {
        return $this->hasMany('App\Models\Event\EventLocation');
    }
    public function audience()
    {
        return $this->hasMany('App\Models\Event\EventAudience');
    }
    public function organizer()
    {
        return $this->hasMany('App\Models\Event\EventOrganizer');
    }
    public function postedby()
    {
        return $this->hasOne('App\Models\Event\EventPostedBy');
    }
    public function type()
    {
        return $this->hasOne('App\Models\Event\EventType');
    }

    public static function getalldetails($arrayofids)
    {
        $events_collection=[];
        foreach ($arrayofids as $arrayofid) {
            $event=Event::find($arrayofid->event_id);
            $languages=Language::getAllLanguages($event->languages->implode('language_id',","));
            $locations=Location::getAllLocations($event->locations->implode('location_id',","));
            $audience=EventAudience::getAllAudiences($event->audience->implode('role_id',","));
             
            $zz=collect($event)->except(['created_at','updated_at','deleted_at'])
                ->merge(['languages'=>explode(',',$languages->implode('language',','))])
                ->merge(['locations'=>explode(',',$locations->implode('location',','))])
                ->merge(['audience'=>explode(',',$audience->implode('name',','))]);
            
            array_push($events_collection, $zz);
        }
        
        return $events_collection;
    }
    
}
