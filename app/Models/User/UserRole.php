<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table="user_roles";
    protected $hidden = ['created_at','updated_at'];
   
}
