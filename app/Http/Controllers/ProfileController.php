<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Models\User\UserPhone;
use App\Models\User\UserDOB;
use App\Models\User\UserRole;
use App\Models\User\UserLanguage;
use App\Models\User\UserLocation;
use App\Models\User\UserDescription;
use App\UserFullDetail;
use App\Models\User\UserConnection;

class ProfileController extends Controller
{
    /*public function getdetails()
    {
    	$user->id=\Auth::user()->id;
    	
    }*/
  public function connect()
  {
    $user1=\Auth::user();
    $user2=User::find(Input::get('uid'));
    
    if($user2){
      $u=new UserConnection;
      $u->user_id1=$user1->id;
      $u->user_id2=$user2->id;
      $u->save();   
      return \Response::json(['msg'=>'success'],200);
    }
     return \Response::json(['msg'=>'error'],400);

  }

  public function connect_requests()
  {
    $user=\Auth::user();
    $users=UserFullDetail::getconnectionrequests($user);

    return \Response::json($users,200);
  }

  public function acceptconnect($id)
  {
    $user=\Auth::user();
    $users=UserConnection::where('user_id2',$user->id)->where('user_id1',$id)->first();
    $users->status=1;
    $users->save();
    return \Response::json(['msg'=>'success'],200);
  }
   public function getconnectedpeople(){
        $user=\Auth::user();

        $totalconnections=UserFullDetail::gettotalconnections($user);
        $connectedpeople=UserFullDetail::getconnectedpeople($user);

        return \Response::json(
          [
            'totalconnections'=>$totalconnections,
            'connectedpeople'=>$connectedpeople
          ],200); 
   }


   public function getfilteredconnectedpeople(){
        $user=\Auth::user();

        $totalconnections=UserFullDetail::gettotalconnections($user);
        $connectedpeople=UserFullDetail::getfilteredconnectedpeople($user,Input::all());

        return \Response::json(
          [
            'totalconnections'=>$totalconnections,
            'connectedpeople'=>$connectedpeople
          ],200); 
   }



    public function getdetails($id)
    {	
    	if($id=='self'){

    		if(\Auth::check()){
    			$id= \Auth::user()->id;
    			return UserFullDetail::getUserDetails($id);
    		}
    		else{
    			return \Response::json(['msg'=>'Please login first!'],401);
    		}
    	}
    	else{
    		return \Response::json(['msg'=>'have id '.$id],200);
    	}
    }


    public function savedetails()
    {
    	if(!\Auth::check()){return \Response::json(['msg'=>'Either You are not authorized or didnt\'t login'],401);}
    	$userid=\Auth::user()->id;
    	
    	$user=User::find($userid);
    	$user->name=Input::get('name');
    	$user->email=Input::get('email');
    	
    	$v=\Validator::make(Input::only(['name','email']), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        
        if($v){ $user->save();	 }
        else{ return \Response::json(['msg'=>'error saving data'],500); }
        /*Saved user above now save details below also*/
        
        $phone=UserPhone::where('user_id',$userid)->first();
        if(!$phone){
          $phone=new UserPhone;
          $phone->user_id=$userid;
        }
        if(Input::get('phone')!==null){
          $phone->phone=Input::get('phone');
          $phone->save();
        }
        else{
          //if the value received is null
          if($phone){ 
            $phone->delete();
          }
        }
        

    	//dd(date("Y-m-d", strtotime(Input::get('dob'))));
        $dob=UserDOB::where('user_id',$userid)->first();
        if(!$dob){
          $dob=new UserDOB;
          $dob->user_id=$userid;
        }
        if(Input::get('dob')){
          $dob->dob=date("Y-m-d", strtotime(Input::get('dob')));
          //dd($dob->dob);
          $dob->save();
        }
        

        
        //save roles
        $roles=UserRole::where('user_id',$userid)->get();
        foreach ($roles as $role) { $role->delete(); }
        
        for($i=0; $i<count(Input::get('roles')); $i++) {
        	$newrole=new UserRole;
        	$newrole->user_id=$userid; 	
        	$newrole->role_id=Input::get('roles')[$i]['role_id'];
        	$newrole->save(); 
         } 

         //save languages
         $languages=UserLanguage::where('user_id',$userid)->get();
         foreach ($languages as $language) { $language->delete(); }
        
         for($i=0; $i<count(Input::get('languages')); $i++) {
        	$newlanguage=new UserLanguage;
        	$newlanguage->user_id=$userid; 	
        	$newlanguage->language_id=Input::get('languages')[$i]['language_id'];
        	$newlanguage->save(); 
          } 

          //save locations
         $locations=UserLocation::where('user_id',$userid)->get();
         foreach ($locations as $location) { $location->delete(); }
        
         for($i=0; $i<count(Input::get('locations')); $i++) {
        	$newlocation=new UserLocation;
        	$newlocation->user_id=$userid; 	
        	$newlocation->location_id=Input::get('locations')[$i]['location_id'];
        	$newlocation->save(); 
         }
          //save description
          $description=UserDescription::where('user_id',$userid)->first();
/*          if($description){
          	$description->user_description=Input::get('description');
          	$description->save();
          }*/
          if(!$description){
          	$description=new UserDescription;
          	$description->user_id=$userid;
          }
          $description->user_description=Input::get('description');
          $description->save();

    	return \Response::json(['msg'=>'Succesfull'],200);
    	
    }

   /* public function getconnectionwithquery($query)
    {
       $user=\Auth::user()->id;
       $connectedpeople=UserFullDetail::getfilteredconnectedpeople($user,[]);
       return $connectedpeople;
    }*/

}
