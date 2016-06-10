<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\File;
use App\Video;

class VideoController extends Controller
{
  public function get($name)
  {
    $file=\Storage::disk('video')->get($name);
    return $file;
  }
  public function delete($name)
  {
    $user=\Auth::user();
    $video=$user->videos()->where('name',$name)->first();
    if($video){
      $video->delete();
      $file=\Storage::disk('video')->delete($name);
    }
    return \Response::json("deleted", 200);

    // else{
    //   return \Response::json("delete error", 500);
    // }
  }

  public function getuploaded()
  {
    $user=\Auth::user();
    return $user->videos;
  }
  public function upload()
  {
      $file=Input::file('file');
      $title=Input::file('title');
      $name="";
    if($file){
      $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
      $originalname=$file->getClientOriginalName();

      \Storage::disk('video')->put($name, File::get($file));
      $video=new Video;
      $video->name=$name;
      $video->title=$title?$title:$originalname;
      $video->originalname=$originalname;
      $video->user_id=\Auth::user()->id;
      $video->save();
    }
      return \Response::json(['name'=>$name],200);
  }
}
