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
    public function search()
    {
      $query=Input::get('query');
      $category=Input::get('category');
      $locations=Input::get('locations');
      $languages=Input::get('languages');
      $roles=Input::get('roles');

      $filters=['locations'=>collect($locations)->map(function($value) { return (int)$value; }),
                'languages'=>collect($languages)->map(function($value) { return (int)$value; }),
                'roles'=>collect($roles)->map(function($value) { return (int)$value; })];

      $me=\Auth::user();

    	if($category==1){//people
          $userArray=[];
    		  $users=User::where('name','LIKE',"%$query%")->get();

          foreach ($users as $key => $user) {
            if($me){ if($me->id==$user->id){ continue; }
                    $user->connection_status=$user->connection_status($me);
            }
              $user->totalconnections=count($user->connections_accepted());
              $user->dob;
              $user_attr=[
                'languages'=>collect($user->languages->pluck('id')),
                'locations'=>collect($user->locations->pluck('id')),
                'roles'=>collect($user->roles->pluck('id'))
              ];
              if($user_attr['roles']->intersect($filters['roles'])==$filters['roles']
                && $user_attr['languages']->intersect($filters['languages'])==$filters['languages']
                && $user_attr['locations']->intersect($filters['locations'])==$filters['locations']
              ){//if all matches
                array_push($userArray,$user);
              }
          }
			return \Response::json($userArray,200);
    	}
    	if($category==0){//job
          $jobs=\App\Job::where('title','LIKE',"%$query%")->get();
          $jobArray=[];
          foreach ($jobs as $key => $job) {
             $job->languages=$job->project->languages;
             $job->locations=$job->project->locations;
             $job->project->project_types;
             $job->roles=[$job->role];
            $job_attr=[
              'languages'=>collect($job->project->languages->pluck('id')),
              'locations'=>collect($job->project->locations->pluck('id')),
              'roles'=>collect([$job->role->id])
            ];
            $job->role;
            if($job_attr['roles']->intersect($filters['roles'])==$filters['roles']
              && $job_attr['languages']->intersect($filters['languages'])==$filters['languages']
              && $job_attr['locations']->intersect($filters['locations'])==$filters['locations']
            ){//if all matches
              array_push($jobArray,$job);
            }

          }
          return $jobArray;
    	}
    	if($category==2){//event
            $events=\App\Event::where('name','LIKE',"%$query%")->get();
            $eventsArray=[];
            $user=\Auth::user();
            foreach ($events as $event) {
                $event_attr=[
                  'languages'=>collect($event->languages->pluck('id')),
                  'locations'=>collect($event->locations->pluck('id')),
                  'audiences'=>collect($event->audiences->pluck('id'))
                ];
                if($event_attr['audiences']->intersect($filters['roles'])==$filters['roles']
                  && $event_attr['languages']->intersect($filters['languages'])==$filters['languages']
                  && $event_attr['locations']->intersect($filters['locations'])==$filters['locations']
                ){//if all matches
                  if($user){ if($user->bookmarked_events->contains($event->id)){  $event->bookmarked=true;  }     }
                  array_push($eventsArray,$event);
                }
            }
            //$eventsArray=\App\Event::getalldetails($events);
            return $eventsArray;
    	}
    	return \Response::json(['msg'=>'Successfully'],200);
    }
}
