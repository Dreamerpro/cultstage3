<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Models\Project\ProjectLanguage;
use App\Models\Project\ProjectLocation;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{

    public function getmyprojects()
    {
    	$user=\Auth::user();
    	$projects=$user->my_projects;
        
        
        foreach ($projects as $project) {
          $project->languages;
          $project->locations;
          $project->project_types;
          $project->projectstatus=$project->project_status($project->projectstatus);
        }
        return $projects;
    }

    public function postnewproject()
    {
    	$user=\Auth::user();
    	
        $project=new Project;
        $project->name=Input::get('title');
        $project->user_id=$user->id;
        $project->details=Input::get('description');
        $project->image=Input::get('image');
        $project->projectstatus=Input::get('productionstage');
        $project->save();

        $type=new \App\Models\Project\ProjectType;
        $type->project_id=$project->id;
        $type->type_id=Input::get('projecttype');
        $type->save();

        $projectlanguage=new ProjectLanguage;
        $projectlanguage->project_id=$project->id;
        $projectlanguage->language_id=Input::get('language');
        $projectlanguage->save();

        $projectlocation=new ProjectLocation;
        $projectlocation->project_id=$project->id;
        $projectlocation->location_id=Input::get('location');
        $projectlocation->save();

//$project->project_type=Input::get('projecttype');
    	return \Response::json(['msg'=>'Succesful'],200);
    }

    public function postnewjob()
    {
        $job=new \App\Job;
        $job->project_id=Input::get('projectid');
        $job->role_id=Input::get('requirement');
        $job->title=Input::get('title');
        $job->last_date=Input::get('date');
        $job->posted_by=\Auth::user()->id;
        $job->save();

        return \Response::json(Input::all());
    }

    public function myjobpostings()
    {
        $jobs=\Auth::user()->job_postings;
        foreach ($jobs as $job) {
           $job->project;
           $job->role;
        }
        return $jobs;
    }

     public function appliedjobs()
    {
        $jobs=\Auth::user()->applied_jobs;
        foreach ($jobs as $job) {
           $job->dajob->project;
           $job->dajob->role;
        }
        return $jobs;
    }
    
    
}
