<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($platform)
    {
        return Socialite::driver($platform)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($platform)
    {
        $user = Socialite::driver($platform)->user();
        
        $cultUser=null;
        $authuser=null;
       // dd($user);
        if(!$user->email){return \Response::json('There must be a email associated with your account!',501);}
        else{
           $cultUser=\App\User::where('email',$user->email)->first();
           
           if(!$cultUser){
             $cultUser=new \App\User;
             $cultUser->name=$user->name;//  (['name'=>$user->name,'email'=>$user->email,'avatar'=>$user->avatar]);
             $cultUser->email=$user->email;
             $cultUser->avatar=$user->avatar;
             $cultUser->save();
           }
           /*else{
             return \Response::json('There is already an account with the email associated with '.$user->email.'!',501);
           }*/
           
           $authuser=\Auth::loginUsingId($cultUser->id);

           
        }
        
        $authcookie=\Cookie::make('authenticated', true, 20,null,null,false,false);
        $username=\Cookie::make('name', $authuser->name,20,null,null,false,false);
        $avatar=\Cookie::make('avatar', \Auth::user()->avatar,20,null,null,false,false);
        $email=\Cookie::make('email', $authuser->email,20,null,null,false,false);
        
        return redirect('/')
        ->withCookie($authcookie)
        ->withCookie($username)
        ->withCookie($avatar)
        ->withCookie($email);
    }
    
}
