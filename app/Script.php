<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $table="scripts";
    protected $fillable=['script','id','title','user_id'];
    protected $visible = ['id','script','title','created_at','updated_at'];
    protected $increments=false;

}
