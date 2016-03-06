<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Detail\Roles;
use App\Models\Detail\Language;
use App\Models\Detail\Location;
use App\Models\Event\EventType;
use App\ProductionStage;
use App\Models\Detail\ProjectType;

class RawDataController extends Controller
{
 	public function getavailableroles (){
 		return Roles::all();
 	}

 	public function getavailablelocations (){
 		return Location::all();
 	}

 	public function getavailablelanguages (){
 		return Language::all();
 	}
 	
 	public function getavailableeventtypes (){
 		return EventType::all();
 	}

 	public function getavailableproductionstages()
 	{
 		return ProductionStage::all();
 	}

 	public function getavailableprojecttypes()
 	{
 		return ProjectType::all();
 	}
 	
}
