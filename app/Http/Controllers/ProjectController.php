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

    public function deleteproject($id)
    {
      $project=Project::findOrFail($id);
      $project->canDelete();
      $project->delete();
      return \Response::json('Project '.$project->name.' successfully deleted!');
    }

    public function postnewproject()
    {
    	$user=\Auth::user();
      $project=null;
if(Input::get('id')){
  $project=$user->my_projects->where('id',Input::get('id'))->first();
  $project->project_types()->detach();
  $project->languages()->detach();
  $project->locations()->detach();
}
else{  $project=new Project; }

        $project->name=Input::get('title');
        $project->user_id=$user->id;
        $project->details=Input::get('description');
        $project->image=Input::get('image');
        $project->projectstatus=Input::get('productionstage');
        $project->save();

        $project->project_types()->attach(Input::get('projecttype'));
        $project->languages()->attach(Input::get('language'));
        $project->locations()->attach(Input::get('location'));

        $project->project_types;
        $project->languages;
        $project->locations;
        $project->projectstatus=$project->project_status($project->projectstatus);

    	return \Response::json(['project'=>$project],200);
    }

    public function postnewjob()
    {
      $job=null;

      if(Input::get('id')){
        $job=\App\Job::findOrFail(Input::get('id'));
        if($job->posted_by!=\Auth::user()->id){abort(403);}//abort
      }
      else{
        $job=new \App\Job;
        $job->posted_by=\Auth::user()->id;
      }

        $job->project_id=Input::get('projectid');
        $job->role_id=Input::get('requirement');
        $job->title=Input::get('title');
        $job->last_date=Input::get('date');

        $job->save();

        return \Response::json(Input::all());
    }
public function deletejob($id)
{
  $job=\App\Job::findOrFail($id);
  if($job->project->user_id==\Auth::user()->id){
    $job->delete();
    return \Response::json("success",200);
  }
  else{   abort(403);  }
}
    public function myjobpostings()
    {
        $jobs=\Auth::user()->job_postings;
        foreach ($jobs as $job) {
           $job->project->project_types;

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
