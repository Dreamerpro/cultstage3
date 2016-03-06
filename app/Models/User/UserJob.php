<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $table="applied_jobs";
  
  
    public function dajob()
    {
    	return $this->belongsTo('App\Job','job_id');
    }
}
