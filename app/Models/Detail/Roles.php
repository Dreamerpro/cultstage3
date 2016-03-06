<?php

namespace App\Models\Detail;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table="roles";

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
