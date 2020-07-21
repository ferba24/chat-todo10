<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\RoomUser;

class ChatController extends Controller
{
    //
	public function create(Request $request) {
		$chat = Chat::create($request->all());
		
		$room = RoomUser::where('user_id', $request->input('user_id'))->
		where('room_id', $request->input('room_id'))->first();
		
		$update = Chat::where('user_id', $request->input('user_id'))->
		where('room_id', $request->input('room_id'))->get();
		
		foreach ($update AS $upd) {
			$upd->json = $room->json;
			$upd->update();
		}
	}
}
