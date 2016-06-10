<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectLocation extends Model
{
     protected $table="project_locations";
     protected $hidden = ['created_at','updated_at'];
}
