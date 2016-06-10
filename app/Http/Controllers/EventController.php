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
use App\Models\Detail\Language;
use App\Models\Detail\Location;


class EventController extends Controller
{

    public function getpostedevents()
    {
        $user=\Auth::user();
        //return Event::getalldetails($user->posted_events);
        $events=$user->posted_events;
        foreach ($events as $key => $event) {
          $event->locations->except(['pivot']);
          $event->languages->except(['pivot']);
          $event->audiences->except(['pivot']);
          $event->nlanguages=array_pluck($event->languages,'language');
          $event->nlocations=array_pluck($event->locations,'location');//explode(',',$event->nlocations->implode('location',','));
          $event->naudience=array_pluck($event->audiences,'name');

          //'languages'=>explode(',',$event->nlanguages->implode('language',',')
        }
        // dd($events);
        return  $events;
    }
    public function bookmarkevent($eid)
    {
      $user=\Auth::user();
      if(!$user->bookmarked_events->contains($eid)){
        $user->bookmarked_events()->attach($eid);
      }
      return \Response::json('Succesfully bookmarked event.',200);
    }
    public function unbookmarkevent($eid)
    {
      $user=\Auth::user();
      if($user->bookmarked_events->contains($eid)){
        $user->bookmarked_events()->detach($eid);
      }
      return \Response::json('Succesfully removed bookmark.',200);
    }
    public function getbookmarkedevents()
    {
        $user=\Auth::user();
        $events=$user->bookmarked_events;
        foreach ($events as $key => $event) {
          $event->locations->except(['pivot']);
          $event->languages->except(['pivot']);
          $event->audiences->except(['pivot']);
          $event->nlanguages=array_pluck($event->languages,'language');
          $event->nlocations=array_pluck($event->locations,'location');//explode(',',$event->nlocations->implode('location',','));
          $event->naudience=array_pluck($event->audiences,'name');

          //'languages'=>explode(',',$event->nlanguages->implode('language',',')
        }

      return \Response::json($events,200);
    }
    public function deleteevent($id)
    {//image should also be deleted

      $event=Event::findOrFail($id);
      //dd($id);
      $event->delete();
      return \Response::json("Successfully deleted event", 200);
    }

    public function postnewevent()
    {

    	$name=Input::get('name');

    	$closingdate=Input::get('closingdate');
    	$startingdate= Input::get('startingdate');
    	//dd(date("d-m-Y", strtotime($startingdate)));

      $event=null;
      if(Input::get("id")){$event=Event::findOrFail(Input::get("id"));}
      else{$event=new Event;}

    	$event->name=Input::get('name');

    	$event->detail=Input::get('detail');
    	$event->address=Input::get('address');
    	$event->end_date=date("Y-m-d", strtotime($closingdate));
    	$event->closing_time=date("Y-m-d H:i:s",strtotime(Input::get('closingtime')));
		  $event->start_date=date("Y-m-d", strtotime($startingdate));
    	$event->starting_time=date("Y-m-d H:i:s",strtotime(Input::get('startingtime')));
    	$event->image=Input::get('image');
      $event->type=Input::get('type');
      $event->postedby=\Auth::user()->id;
    	$event->save();

    	//$eventid=$event->id;

    	//save event language maps
      $event->languages()->detach();
      $event->locations()->detach();
      $event->audiences()->detach();

      foreach (Input::get('languages') as $value) {       $event->languages()->attach($value['id']);   	}
      foreach (Input::get('locations') as $value) {       $event->locations()->attach($value['id']);  	}
    	foreach (Input::get('audiences') as $value) {       $event->audiences()->attach($value['id']);  	}
      $event->save();

    	return \Response::json(['msg'=>'Successfully posted the event!.'], 200);
    }

}
