<?php

namespace App\Models\Detail;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table="locations";

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
