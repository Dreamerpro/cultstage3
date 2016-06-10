<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table="user_locations";
    protected $hidden = ['created_at','updated_at'];
}
