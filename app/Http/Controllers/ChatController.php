<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Chat;
use App\Events\MessageSent;

class ChatController extends Controller{
	public function create(Request $req) {
		$message = new Chat;
		$message->user_id = $req->get('user');
		$message->room_id = $req->get('room');
		$message->messages = $req->get('message');
		$message->json = ""; // Borrar esta columna en la DB
		$message->save();

		$user = \DB::table('xenusers')->where('user_id', $message->user_id)->first();

		broadcast(new MessageSent(
					$message->room_id, 
					$user->json, 
					$message->messages, 
					$message->created_at
				))->toOthers();
		
		return response(json_encode([
			'user' => $user->json, 
			'room' => $message->room_id,
			'message' => $message->messages,
			'date' => $message->created_at
		]));
	}
	public function getMessages(){
		$messages = \DB::table('chat')
					->leftJoin('xenusers', 'chat.user_id', 'xenusers.user_id')
					->select('xenusers.json as user', 'chat.room_id as room', 'chat.messages as message', 'chat.created_at as date')->orderBy('chat.created_at','ASC')->get();
		return response($messages->toJson());
	}
}
