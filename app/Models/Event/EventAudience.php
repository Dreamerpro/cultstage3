<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use App\Models\Detail\Roles;

class EventAudience extends Model
{
    protected $table="event_audiences";

    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
    public static function getAllAudiences($array)//array of ids
    {
    	$array=explode(',',$array );
    	//dd($array);
    	$out =new \Illuminate\Database\Eloquent\Collection;
    	foreach ($array as $item) {
    		$out->push(Roles::find($item));
    	}
    	return $out;
    }
}
