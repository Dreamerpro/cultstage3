<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CultstageAuthController extends Controller
{
    public function login()
    {
    	$email=Input::json('email');
    	$password=Input::json('password');
    	//dd($email.' '.$password);
    	if(\Auth::attempt(['email'=>$email,'password'=>$password])){
    		return \Auth::user();
    	}
    	else{
    		return \Response::json(['msg'=>'Invalid credentials'],500);
    	}

    }
/*    public function logout()
    {

    }
    public function register()
    {
    	$name=Input::json('name');
    	$email=Input::json('email');
    	$password=Input::json('password');
    	//dd($email.' '.$password);
    	if(\Auth::attempt(['email'=>$email,'password'=>$password],true)){
    		return \Auth::user();
    	}
    	else{
    		return \Response::json(['msg'=>'Invalid credentials'],400);
    	}
    	if(\Auth::create(Input::all())){
    		return \Auth::check();
    	}

    }*/
}
