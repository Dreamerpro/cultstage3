<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Input;
use Webpatser\Uuid\Uuid;

class PostController extends Controller
{
   
   	public function getmyposts()
   	{
   		$user=\Auth::user();
   		return \Response::json($user->posts,200);
   	}
   	public function post()
   	{
   		$user=\Auth::user();
   		$uuid=Uuid::generate();
   		$post=new Post(['body'=>Input::get('body'),'uuid'=>$uuid]);
   		$user->posts()->save($post);
   		$post->uuid=(string)$uuid;
   		return \Response::json($post,200);
   	}
   	public function delete($uuid)
   	{
   		$user=\Auth::user();
   		$post=$user->posts()->where('uuid',$uuid)->first();
   		if($post){$post->delete();return \Response::json($post,200);}
   		else{return \Response::json(['msg'=>'Post doesn\'t belong to you'],401);}
   		
   	}
   	public function edit_post()
   	{
   		$user=\Auth::user();
   		$post=$user->posts()->where('uuid',Input::get('uuid'))->first();
   		if($post){$post->body=Input::get('body'); $post->save(); return \Response::json($post,200);}
   		else{return \Response::json(['msg'=>'Post doesn\'t belong to you'],401);}
   	}
   	
}
