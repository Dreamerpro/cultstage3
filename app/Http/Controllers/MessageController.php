<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\UserFullDetail;
use App\Message;
use Webpatser\Uuid\Uuid;

class MessageController extends Controller
{
    public function send()
    {
    	$user=\Auth::user();
    	
    	$to=Input::get('to');
    	
    	$id_collection=collect([]);
		
		$cons=collect(collect(UserFullDetail::getconnectedpeople($user))->toArray());
		foreach ($cons as $con) {
			$id_collection->push($con['id']);
		}

		if($id_collection->contains($to)){//if connection exists then send message
			$message=new Message;
			$message->uuid=Uuid::generate();
			$message->to=$to;
			$message->from=$user->id;
			$message->body=Input::get('msg');
			$message->subject=Input::get('subject');
			$message->save();
		}
		else{
			return \Response::json(['msg'=>'You are not connected with the receiver'],401);
		}

		return \Response::json(['msg'=>'Succesfully sent the message.'],200);
    }

    public function get_inbox()
    {
    	$user=\Auth::user();
    	$messages=Message::where('to',$user->id)->where('deleted','!=',1)->where('deleted','!=',3)->get();
    	foreach ($messages as $msg) {
    		$msg->from=\App\User::find($msg->from);
    	}
    	
    	return \Response::json($messages?$messages->toArray():[],200);
    }

    public function get_sent()
    {
    	$user=\Auth::user();
    	$messages=Message::where('from',$user->id)->where('deleted','!=',2)->where('deleted','!=',3)->get();
    	foreach ($messages as $msg) {
    		$msg->to=\App\User::find($msg->to);
    	}
    	return \Response::json($messages?$messages->toArray():[],200);
    }
     public function get_msg($uuid)
    {
    	$user=\Auth::user();
    	$messages=Message::where('uuid',$uuid)->get();
    	
    	return \Response::json($messages?$messages->toArray():[],200);
    }

    public function del_msg()
    {
        $messages=[];
        foreach (Input::get('uuids') as $uuid) {
           $msg=Message::where('uuid',$uuid)->get()->first();
           
           if($msg->deleted===0){
                $msg->deleted=(Input::get('type')===1)?1:2;
           }
           else if($msg->deleted===2){
                $msg->deleted=(Input::get('type')===1)?3:2;
           }
           else if($msg->deleted===1){
                $msg->deleted=(Input::get('type')===2)?3:1;
           }
           $msg->save();
        }
        
        return $messages;
    }
}
