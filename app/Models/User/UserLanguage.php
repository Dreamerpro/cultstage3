<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $table="user_languages";
    protected $hidden = ['created_at','updated_at'];
}
