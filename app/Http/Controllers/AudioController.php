<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\File;
use App\Audio;

class AudioController extends Controller
{
  public function get($name)
  {
    $file=\Storage::disk('audio')->get($name);
    return $file;
  }
  public function delete($name)
  {
    $user=\Auth::user();
    $audio=$user->audios()->where('name',$name)->first();
    if($audio){
      $audio->delete();
      $file=\Storage::disk('audio')->delete($name);
    }
    return \Response::json("delete success", 200);
    //
    // else{
    //   return \Response::json("delete error", 500);
    // }
  }
  public function getuploaded()
  {
    $user=\Auth::user();
    return $user->audios;
  }
  public function upload()
  {
      $file=Input::file('file');
      $title=Input::file('title');
      $name="";
    if($file){
      $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
      $originalname=$file->getClientOriginalName();

      \Storage::disk('audio')->put($name, File::get($file));
      $audio=new Audio;
      $audio->name=$name;
      $audio->title=$title?$title:$originalname;
      $audio->originalname=$originalname;
      $audio->user_id=\Auth::user()->id;
      $audio->save();
    }
      return \Response::json(['name'=>$name],200);
  }
}
