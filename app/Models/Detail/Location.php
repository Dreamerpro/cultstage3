<?php

namespace App\Models\Detail;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table="locations";
    protected $hidden = ['created_at','updated_at','pivot'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
     public static function getAllLocations($array){//$array of ids
    	$array=explode(',',$array );
    	$out=new \Illuminate\Database\Eloquent\Collection;

    	foreach ($array as $id) {
    		$out->push(Location::find($id)->toArray());
    	}
    	return $out;
    }
}
