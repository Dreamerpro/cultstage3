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
        //return $this->hasOne('\App\ProductionStage','production_stages','project_id','type_id');
        return collect(\App\ProductionStage::find($id)->toArray());
    }

    public function users()
    {
    	return $this->hasOne('App\User');
    }
    public function canDelete()// should be changed with gate
    {
      if($this->user_id!=\Auth::user()->id){  abort(403);   }
    }

}
