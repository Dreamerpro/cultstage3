<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class ScriptController extends Controller
{
    public function saveScript()
    {
      $title=Input::get('title');
      $script=Input::get('script');
      if($title && $script){
        $script=\App\Script::create(['title'=>$title,'script'=>$script,'user_id'=>\Auth::user()->id]);
        return $script;
      }
      return \Response::json("Error saving script",500);
    }
    public function updateScript()
    {

      $script=\App\Script::find(Input::get('id'));
      if(\Auth::user()->cannot('update-script', $script)){
        abort(403);
      }
      else{
        $script->title=Input::get('title');
        $script->script=Input::get('script');
        $script->save();
        return \Response::json("Succesfully updated the script", 200);
      }
    }

    public function deleteScript($id)
    {

      $script=\App\Script::find($id);
      if(\Auth::user()->cannot('delete-script', $script)){
        abort(403);
      }
      else{
        $script->delete();
        return \Response::json("Succesfully deleted", 200);
      }
    }
    public function getmyscripts()
    {
      return \Auth::user()->scripts;
    }
}
