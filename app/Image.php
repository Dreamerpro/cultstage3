<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table="images";

    public function scopeIsMine($query,$userid)
    {
    	return $query->where('user_id',$userid)->first();
    }
}
