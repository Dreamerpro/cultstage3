<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Detail\Language;
use App\Models\Detail\Location;
use App\Models\Detail\Roles;
use App\Models\User\UserDescription;
use App\Models\User\UserConnection;
use App\User;

class UserFullDetail extends Model
{
    public  static function getUserDetails($id)
    {
    	if(!$id){return false;}
    	$user=User::find($id);
   
   		
   		$languages=UserFullDetail::getlanguages($user);
   		$locations=UserFullDetail::getlocations($user);
      $roles=UserFullDetail::getroles($user);
      $description=UserDescription::where('user_id',$id)->first()?UserDescription::where('user_id',$id)->first()->user_description:null;
      $totalconnection=UserFullDetail::gettotalconnections($user);

    	$userbasic=collect([
        'id'=>$user->id,
    		'name'=>$user->name,
    		'email'=>$user->email,
    		'avatar'=>$user->avatar,
    		'phone'=>$user->phone?$user->phone->phone:null,
    		'dob'=>$user->dob?$user->dob->dob:null,
    		'languages'=>$languages,
    		'locations'=>$locations,
        'roles'=>$roles,
        'description'=>$description,
        'totalconnection'=>$totalconnection,
        'membersince'=>$user->created_at
    		]);
		
    	return $userbasic;
    }


    public static function getlanguages($user)
    {
    	$languagemodel=$user->languages->toArray();
   		$languages=[];
   		foreach ($languagemodel as $val) {
   			array_push($languages, ['language_id'=>$val['language_id'],'language'=>Language::find($val['language_id'])->language]);		
   		}
   		return $languages;
    }
    public static function getlocations($user)
    {
    	$locationmodel=$user->locations->toArray();
   		$locations=[];
   		foreach ($locationmodel as $val) {
   			array_push($locations, ['location_id'=>$val['location_id'],'location'=>Location::find($val['location_id'])->location]);		
   		}
   		return $locations;
    }
    public static function getroles($user)
    {
      $rolemodel=$user->roles->toArray();
      $roles=[];
      foreach ($rolemodel as $val) {
        array_push($roles, ['role_id'=>$val['role_id'],'name'=>Roles::find($val['role_id'])->name]);    
      }
      return $roles;
    }
    public static function gettotalconnections($user){
      
       $total_con=UserConnection::where('user_id1',$user->id)->where('status',1)->get()?count(UserConnection::where('user_id1',$user->id)->where('status',1)->get()):0;
       $total_con+=UserConnection::where('user_id2',$user->id)->where('status',1)->get()?count(UserConnection::where('user_id2',$user->id)->where('status',1)->get()):0;
      return $total_con;
    }
    
    public static function getconnectedpeople($user){
      $peoples=UserConnection::where('user_id1',$user->id)->where('status',1)->get();
      $resultpeople=[];
      foreach ($peoples as $people) {
          //
         
          $conuser=User::find($people->user_id2);
          $totalcon=UserFullDetail::gettotalconnections($conuser);
          $languagearray=UserFullDetail::getlanguages($conuser);
          $locationarray=UserFullDetail::getlocations($conuser);
          $rolesarray=UserFullDetail::getroles($conuser);



          array_push($resultpeople, 
            [
              'id'=>$conuser->id,
              'name'=>$conuser->name,
              'avatar'=>$conuser->avatar,
              'totalconnections'=>$totalcon,
              'languages'=>UserFullDetail::getLanguageValues($languagearray),
              'locations'=>UserFullDetail::getLocationValues($locationarray),//UserFullDetail::getLocationValues($locationarray),
              'roles'=>UserFullDetail::getRolesValues($rolesarray),
              'membersince'=>$conuser->created_at
            ]);

      }
      $peoples1=UserConnection::where('user_id2',$user->id)->where('status',1)->get();
      foreach ($peoples1 as $people) {
          //
         
        $conuser=User::find($people->user_id1);
        $totalcon=UserFullDetail::gettotalconnections($conuser);
        $languagearray=UserFullDetail::getlanguages($conuser);
        $locationarray=UserFullDetail::getlocations($conuser);
        $rolesarray=UserFullDetail::getroles($conuser);

        array_push($resultpeople, 
          [
            'id'=>$conuser->id,
            'name'=>$conuser->name,
            'avatar'=>$conuser->avatar,
            'totalconnections'=>$totalcon,
            'languages'=>UserFullDetail::getLanguageValues($languagearray),
            'locations'=>UserFullDetail::getLocationValues($locationarray),//UserFullDetail::getLocationValues($locationarray),
            'roles'=>UserFullDetail::getRolesValues($rolesarray),
            'membersince'=>$conuser->created_at
          ]);
      }
      
      return $resultpeople;
    }

    public static function getconnectionrequests($user){
      $peoples=UserConnection::where('user_id1',$user->id)->where('status',0)->get();
      $resultpeople=[];
      foreach ($peoples as $people) {
          //
         
          $conuser=User::find($people->user_id2);
          $totalcon=UserFullDetail::gettotalconnections($conuser);
          $languagearray=UserFullDetail::getlanguages($conuser);
          $locationarray=UserFullDetail::getlocations($conuser);
          $rolesarray=UserFullDetail::getroles($conuser);



          array_push($resultpeople, 
            [
              'id'=>$conuser->id,
              'name'=>$conuser->name,
              'avatar'=>$conuser->avatar,
              'totalconnections'=>$totalcon,
              'languages'=>UserFullDetail::getLanguageValues($languagearray),
              'locations'=>UserFullDetail::getLocationValues($locationarray),//UserFullDetail::getLocationValues($locationarray),
              'roles'=>UserFullDetail::getRolesValues($rolesarray),
              'membersince'=>$conuser->created_at
            ]);

      }
      $peoples1=UserConnection::where('user_id2',$user->id)->where('status',0)->get();
      foreach ($peoples1 as $people) {
          //
         
        $conuser=User::find($people->user_id1);
        $totalcon=UserFullDetail::gettotalconnections($conuser);
        $languagearray=UserFullDetail::getlanguages($conuser);
        $locationarray=UserFullDetail::getlocations($conuser);
        $rolesarray=UserFullDetail::getroles($conuser);

        array_push($resultpeople, 
          [
            'id'=>$conuser->id,
            'name'=>$conuser->name,
            'avatar'=>$conuser->avatar,
            'totalconnections'=>$totalcon,
            'languages'=>UserFullDetail::getLanguageValues($languagearray),
            'locations'=>UserFullDetail::getLocationValues($locationarray),//UserFullDetail::getLocationValues($locationarray),
            'roles'=>UserFullDetail::getRolesValues($rolesarray),
            'membersince'=>$conuser->created_at
          ]);
      }
      
      return $resultpeople;
    }

    public static function getpeoplesearch($users ,$filter){
      $me=null;
      if(\Auth::user()){$me=\Auth::user()->id;}
      $resultpeople=[];

      $filterlocations=collect($filter['locations']);
      $filterlanguages=collect($filter['languages']);
      $filterroles=collect($filter['roles']);
      foreach ($users as $conuser) {
          //array_push($userArray, UserFullDetail::getpeoplesearch($user)) ;
            $totalcon=UserFullDetail::gettotalconnections($conuser);
            $languagearray=collect(UserFullDetail::getlanguages($conuser));
              foreach ($filterlanguages as $language) {
                if(!$languagearray->contains('language_id',$language['language_id'])) { continue 2; }
              }

              $locationarray=collect(UserFullDetail::getlocations($conuser));
              foreach ($filterlocations as $location) {
                if(!$locationarray->contains('location_id',$location['location_id'])) { continue 2; }
              }

              $rolesarray=collect(UserFullDetail::getroles($conuser));

              foreach ($filterroles as $role) {
                if(!$rolesarray->contains('role_id',$role['role_id'])) { continue 2; }
              }
              if($conuser->id!== $me){//if not me
                  array_push($resultpeople, [
                    'id'=>$conuser->id,
                    'name'=>$conuser->name,
                    'avatar'=>$conuser->avatar,
                    'totalconnections'=>$totalcon,
                    'languages'=>UserFullDetail::getLanguageValues($languagearray),
                    'locations'=>UserFullDetail::getLocationValues($locationarray),
                    'roles'=>UserFullDetail::getRolesValues($rolesarray),
                    'membersince'=>$conuser->created_at,
                  ]);
              }
              

        }
      
      return $resultpeople;

      



          
  
  }

    public static function getfilteredconnectedpeople($user ,$filter){
      $peoples=UserConnection::where('user_id1',$user->id)->where('status',1)->get();
      
      $resultpeople=[];

      $filterlocations=collect($filter['locations']);
      $filterlanguages=collect($filter['languages']);
      $filterroles=collect($filter['roles']);

//searching for user_id2
      foreach ($peoples as $people) {
          //
          $continue=false;
          $conuser=User::find($people->user_id2);
          //dd($conuser);
          $totalcon=UserFullDetail::gettotalconnections($conuser);

          $languagearray=collect(UserFullDetail::getlanguages($conuser));
          foreach ($filterlanguages as $language) {
            if(!$languagearray->contains('language_id',$language['language_id'])) { continue 2; }
          }

          $locationarray=collect(UserFullDetail::getlocations($conuser));
          foreach ($filterlocations as $location) {
            if(!$locationarray->contains('location_id',$location['location_id'])) { continue 2; }
          }

          $rolesarray=collect(UserFullDetail::getroles($conuser));

          foreach ($filterroles as $role) {
            if(!$rolesarray->contains('role_id',$role['role_id'])) { continue 2; }
          }

          array_push($resultpeople, 
            [
              'id'=>$conuser->id,
              'name'=>$conuser->name,
              'avatar'=>$conuser->avatar,
              'totalconnections'=>$totalcon,
              'languages'=>UserFullDetail::getLanguageValues($languagearray),
              'locations'=>UserFullDetail::getLocationValues($locationarray),
              'roles'=>UserFullDetail::getRolesValues($rolesarray),
              'membersince'=>$conuser->created_at,
            ]);
      }
//searching for user_id1
      $peoples1=UserConnection::where('user_id2',$user->id)->where('status',1)->get();
      foreach ($peoples1 as $people) {
          //
          $continue=false;
          $conuser=User::find($people->user_id1);
          //dd($conuser);
          $totalcon=UserFullDetail::gettotalconnections($conuser);

          $languagearray=collect(UserFullDetail::getlanguages($conuser));
          foreach ($filterlanguages as $language) {
            if(!$languagearray->contains('language_id',$language['language_id'])) { continue 2; }
          }

          $locationarray=collect(UserFullDetail::getlocations($conuser));
          foreach ($filterlocations as $location) {
            if(!$locationarray->contains('location_id',$location['location_id'])) { continue 2; }
          }

          $rolesarray=collect(UserFullDetail::getroles($conuser));

          foreach ($filterroles as $role) {
            if(!$rolesarray->contains('role_id',$role['role_id'])) { continue 2; }
          }

          array_push($resultpeople, 
            [
              'id'=>$conuser->id,
              'name'=>$conuser->name,
              'avatar'=>$conuser->avatar,
              'totalconnections'=>$totalcon,
              'languages'=>UserFullDetail::getLanguageValues($languagearray),
              'locations'=>UserFullDetail::getLocationValues($locationarray),
              'roles'=>UserFullDetail::getRolesValues($rolesarray),
              'membersince'=>$conuser->created_at,
            ]);
      }


      return $resultpeople;
    }


    public static function getLocationValues($array){
        $names=[];
        $ids=[];
        for ($i=0; $i <count($array) ; $i++) { 
          array_push($names,$array[$i]['location']);
          array_push($ids,$array[$i]['location_id']);
        }
        return ['ids'=>$ids,'names'=>$names];
    }
    public static  function getLanguageValues($array){
        $names=[];
        $ids=[];
        for ($i=0; $i <count($array) ; $i++) { 
          array_push($names,$array[$i]['language']);
          array_push($ids,$array[$i]['language_id']);
        }
        return ['ids'=>$ids,'names'=>$names];
    }
    public static function  getRolesValues($array){
        $names=[];
        $ids=[];
        for ($i=0; $i <count($array) ; $i++) { 
          array_push($names,$array[$i]['name']);
          array_push($ids,$array[$i]['role_id']);
        }
        return ['ids'=>$ids,'names'=>$names];
    }
}
