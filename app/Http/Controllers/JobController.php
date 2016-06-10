<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class JobController extends Controller
{
    public function getappliedjobs()
    {
      $user=\Auth::user();
      foreach ($user->applied_jobs as $key => $value) {
        $project=$value->project;
        $project->languages;
        $project->locations;
        $project->project_types;
        $project->projectstatus=$project->project_status($project->projectstatus);
        $value->role;
      };
      return $user->applied_jobs;
    }
    public function applyforjob($jobid)
    {
      $user=\Auth::user();
      if(!$user->applied_jobs->contains($jobid)){ $user->applied_jobs()->attach($jobid); }
      return \Response::json('success',200);
    }
    public function removeapplication($jobid)
    {
      $user=\Auth::user();
      if($user->applied_jobs->contains($jobid)){ $user->applied_jobs()->detach($jobid); }
      return \Response::json('success',200);
    }
}
