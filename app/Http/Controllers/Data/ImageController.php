<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\File;
use App\Image;

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
		$image->type=2;
      $image->user_id=\Auth::user()->id;
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

       Image::where('name',$filename)->first()->delete();
       return \Response::json(['msg'=>'successful'],200);
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
      
      return $file;
   }
}
