<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table="jobs";
    protected $hidden = ['created_at','updated_at'];
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    public function role()
    {
    	return $this->belongsTo('App\Models\Detail\Roles');
    }
}
