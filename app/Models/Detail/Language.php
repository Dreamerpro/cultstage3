<?php

namespace App\Models\Detail;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table="languages";

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public static function getAllLanguages($array){//$array of ids
    	$array=explode(',',$array );
    	$out=new \Illuminate\Database\Eloquent\Collection;
    	
    	foreach ($array as $id) {
    		$out->push(Language::find($id)->toArray());
    	}
    	return $out;
    }
}
