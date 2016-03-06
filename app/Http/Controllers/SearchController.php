<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\UserFullDetail;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function search($query, $category)
    {
    	if($category==1){//people
    		$users=User::where('name','LIKE',"%$query%")->get();
            $filters=Input::all();
            $filters=['locations'=>[],'languages'=>[],'roles'=>[]];
            if(count(Input::all())<1){
                $filters=['locations'=>[],'languages'=>[],'roles'=>[]];
            }
            else{
                $filters=['locations'=>Input::get('locations'),'languages'=>Input::get('languages'),'roles'=>Input::get('roles')];
            }
           
            $userArray=UserFullDetail::getpeoplesearch($users,$filters);
    		
			return $userArray;
    	}
    	if($category==0){//job
    		
    	}
    	if($category==2){//event
            $events=\App\Event::where('name','LIKE',"%$query%")->get();
            foreach ($events as $event) {
                $event->event_id=$event->id;
            }
            $eventsArray=\App\Event::getalldetails($events);
            return $eventsArray;
    	}
    	return $query.'as'.$category;
    }
}
