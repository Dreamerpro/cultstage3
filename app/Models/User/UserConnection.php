<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    protected $table="user_connections";
    protected $hidden=["created_at",'updated_at'];
}
