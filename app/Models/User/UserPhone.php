<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $table="user_phones";
    protected $hidden = ['created_at','updated_at'];
}
