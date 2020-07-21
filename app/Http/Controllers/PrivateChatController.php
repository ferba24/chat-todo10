<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrivateChatUser;
use App\PrivateChatUserChat;

class PrivateChatController extends Controller
{
    //
	public function index() {
		
	}
	
	//
	public function stored($user_private_id) {
		
		$user_private = PrivateChatUser::where('user_id',session('user'))
			->where('user_private_id',$user_private_id)->first();
		
		session(['private_user_id', $user_private_id]);
		if(!$user_private) {
			
			$private = new PrivateChatUser();
			$private->user_id = session('user');
			$private->user_private_id = $user_private_id; 
			$private->save();
		}
		
		return true;
	}
	
	//
	public function stored_messages(Request $request) {
		$chat = PrivateChatUserChat::create($request->all());
	}
	
	//
	public function getPrivateUser($private = null) {
		$user_private = PrivateChatUser::where('user_id',session('user'))
			->where('user_private_id',$private)->first();
		return $user_private;
	}
}
