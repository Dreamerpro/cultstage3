<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $table="project_types_map";
    protected $hidden = ['created_at','updated_at'];
}
