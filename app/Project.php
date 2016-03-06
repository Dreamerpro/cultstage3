<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table="projects";

    public function languages()
    {
    	return $this->belongsToMany('App\Models\Detail\Language','project_languages');
    }
    public function locations()
    {
    	return $this->belongsToMany('App\Models\Detail\Location','project_locations');
    }
    public function project_types()
    {
    	return $this->belongsToMany('App\Models\Detail\ProjectType','project_types_map','project_id','type_id');
    }
    public function project_status($id)
    {
        return collect(\App\ProductionStage::find($id)->toArray())->only('name');
    }

    public function users()
    {
    	return $this->hasOne('App\User');
    }

}
