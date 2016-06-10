<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Project;

class ImageController extends Controller
{
   public function uploadeventimage()
   {
   		$file=Input::file('file');
   		$name="";
   	if($file){
   		$name= Uuid::generate().'.'.$file->getClientOriginalExtension();
   		$originalname=$file->getClientOriginalName();

   		\Storage::disk('eventimage')->put($name, File::get($file));
   		$image=new Image;
   		$image->name=$name;
		  $image->originalname=$originalname;
		  $image->type=2;//event
      $image->user_id=\Auth::user()->id;
		  $image->save();
	}
   		return \Response::json(['name'=>$name],200);
   }
   public function albumimages()
   {
     return \Auth::user()->images()->where('type',4)->get();
   }
   public function uploadalbumimage()
   {
         $file=Input::file('file');
         $name="";
         $nos=count(\Auth::user()->images()->where('type',4)->get()->toArray());
         if($nos==5){
           abort(403);
         }
      if($file){
         $name= Uuid::generate().'.'.$file->getClientOriginalExtension();

         $originalname=$file->getClientOriginalName();

         \Storage::disk('albumimage')->put($name, File::get($file));
         $image=new Image;
         $image->name=$name;
         $image->originalname=$originalname;
         $image->user_id=\Auth::user()->id;
         $image->type=4;//album
         $image->save();
       }
         return \Response::json(['name'=>$name],200);
   }

   public function uploadprojectimage()
   {
         $file=Input::file('file');
         $name="";
      if($file){
         $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
         $originalname=$file->getClientOriginalName();

         \Storage::disk('projectimage')->put($name, File::get($file));
         $image=new Image;
         $image->name=$name;
      $image->originalname=$originalname;
      $image->user_id=\Auth::user()->id;
      $image->type=3;//project
      $image->save();
   }
         return \Response::json(['name'=>$name],200);
   }
   public function uploadprofileimage(Request $req)
   {
         $file=Input::file('file');
         $name="";

         $user=\Auth::user();
         $uid=$user->id;
         //delete current profile image
         $image=Image::where('user_id',$uid)->where('type',1)->first();
         if($image){ $image->delete();  \Storage::disk('profileimage')->delete($image->name);     }

      if($file){
         $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
         $originalname=$file->getClientOriginalName();

         \Storage::disk('profileimage')->put($name, File::get($file));
         $image=new Image;
         $image->name=$name;
         $image->originalname=$originalname;
         $image->user_id=$uid;
         $image->type=1;//profileimage
         $image->save();



           $user->avatar='/asset/image/1/'.$name;}
           $user->save();

         return \Response::json(['avatar'=>$user->avatar],200);
   }
   public function uploadImageAT($type)//not used should be used later********************
   {
     $file=Input::file('file');
     $name="";

     $user=\Auth::user();
     $uid=$user->id;
     //requried for deleting current profile or cover image
     $image=Image::where('user_id',$uid)->where('type',$type)->first();
     if($type==1 && $image){    $image->delete();  \Storage::disk('profileimage')->delete($image->name);          }
     else if($type==5 && $image){   $image->delete();  \Storage::disk('coverimage')->delete($image->name);        }

  if($file){
     $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
     $originalname=$file->getClientOriginalName();

     \Storage::disk('coverimage')->put($name, File::get($file));
     $image=new Image;
     $image->name=$name;
     $image->originalname=$originalname;
     $image->user_id=$uid;
     $image->type=$type;//type
     $image->save();


    //  if(\App::environment()=='local'){$user->avatar='http://dev.cultstage.com'.'/asset/image/1/'.$name;}
    //  else{

//}
    $url='/asset/image/'.$type.'/'.$name;
      if($type==1){
        $user->avatar=$url;
        $user->save();
        return \Response::json(['avatar'=>$user->avatar],200);
      }
      else if($type==5){
        $user->cover=$url;
        $user->save();
        return \Response::json(['cover'=>$user->cover],200);}
      }
      return \Response::json(['img'=>$url],200);

   }
   public function uploadcoverimage(Request $req)
   {
         $file=Input::file('file');
         $name="";

         $user=\Auth::user();
         $uid=$user->id;
         //delete current profile image
         $image=Image::where('user_id',$uid)->where('type',5)->first();
         if($image){ $image->delete();  \Storage::disk('coverimage')->delete($image->name);     }

      if($file){
         $name= Uuid::generate().'.'.$file->getClientOriginalExtension();
         $originalname=$file->getClientOriginalName();

         \Storage::disk('coverimage')->put($name, File::get($file));
         $image=new Image;
         $image->name=$name;
         $image->originalname=$originalname;
         $image->user_id=$uid;
         $image->type=5;//coverimage
         $image->save();


        //  if(\App::environment()=='local'){$user->avatar='http://dev.cultstage.com'.'/asset/image/1/'.$name;}
        //  else{
          $user->cover='/asset/image/5/'.$name;}
          $user->save();
   //}
         return \Response::json(['cover'=>$user->cover],200);
   }

   public function deleteimage()
   {
      $filename=Input::get('filename');
      $type=Input::get('type');

      $image=Image::where('name',$filename)->isMine(\Auth::user()->id)->get();
      if(!$image){dd('This image doesnt belong to you.');}

      if($type==2)//eventimage
      {
         \Storage::disk('eventimage')->delete($filename);
      }
      else if($type==3)//projectimage
      {
         \Storage::disk('projectimage')->delete($filename);
      }
      else if($type==4)//projectimage
      {
         \Storage::disk('albumimage')->delete($filename);
      }
      else if($type==5)//coverimage
      {
         \Storage::disk('coverimage')->delete($filename);
      }


       Image::where('name',$filename)->first()->delete();
       return \Response::json(['msg'=>'successful'],200);
   }

public function deleteprojectimage($id)
{
  $p=Project::findOrFail($id);
  $p->image=null;
  $p->save();
  return \Response::json(['success'],200);
}
   public function getimage($type,$filename)
   {
      $file=null;

      if($type==3){
         $file=\Storage::disk('projectimage')->get($filename);
      }
      else if($type==2){
         $file=\Storage::disk('eventimage')->get($filename);
      }
      else if($type==1)//eventimage
      {
         $file=\Storage::disk('profileimage')->get($filename);
      }
      else if($type==4)//eventimage
      {
         $file=\Storage::disk('albumimage')->get($filename);
      }
      else if($type==5)//coverimage
      {
         $file=\Storage::disk('coverimage')->get($filename);
      }

      return $file;
   }
}
