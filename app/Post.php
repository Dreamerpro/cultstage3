<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table="posts";

    protected $fillable=['body','uuid'];
    protected $visible = ['uuid','body','created_at','updated_at'];
    protected $hidden = ['id'];
}
