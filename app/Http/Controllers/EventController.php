<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Event;
use App\Models\Event\EventLanguage;
use App\Models\Event\EventLocation;
use App\Models\Event\EventPostedBy;
use App\Models\Event\EventAudience;

class EventController extends Controller
{

    public function getpostedevents()
    {
        $user=\Auth::user();
        return Event::getalldetails($user->posted_events);
    }

    public function getbookmarkedevents()
    {
        $user=\Auth::user();
        $eventids=$user->bookmarked_events;
        return Event::getalldetails($eventids);
    }

    public function postnewevent()
    {

    	$name=Input::get('name');
    	
    	$closingdate=Input::get('closingdate');
    	$startingdate= Input::get('startingdate');
    	//dd(date("d-m-Y", strtotime($startingdate)));
    	
    	$event=new Event;
    	$event->name=Input::get('name');
    	
    	$event->detail=Input::get('description');
    	$event->address=Input::get('address');
    	$event->end_date=date("Y-m-d", strtotime($closingdate));
    	$event->closing_time=Input::get('closingtime');
		$event->start_date=date("Y-m-d", strtotime($startingdate));
    	$event->starting_time=Input::get('startingtime');
    	$event->image=Input::get('image');
    	//dd($event);
    	$event->save();

    	$eventid=$event->id;
    	
    	//save event language maps
    	foreach (Input::get('languages') as $value) {
    		$eventlang=new EventLanguage;
    		$eventlang->event_id=$eventid;
    		$eventlang->language_id=$value['language_id'];
    		$eventlang->save();
    	}

    	foreach (Input::get('locations') as $value) {
    		$eventlocation=new EventLocation;
    		$eventlocation->event_id=$eventid;
    		$eventlocation->location_id=$value['location_id'];
    		$eventlocation->save();
    	}
    	// /
    	foreach (Input::get('audiences') as $value) {
    		$eventaudience=new EventAudience;
    		$eventaudience->event_id=$eventid;
    		$eventaudience->role_id=$value['role_id'];
    		$eventaudience->save();
    	}


    	$eventpb=new EventPostedBy;
    	$eventpb->event_id=$eventid;
    	$eventpb->user_id=\Auth::user()->id;
    	$eventpb->save();

    	return \Response::json(['msg'=>'Successfully posted the event!.'], 200);
    }

}
