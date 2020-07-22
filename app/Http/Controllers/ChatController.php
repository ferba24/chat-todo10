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
		$message->json = "";
		$message->save();

		broadcast(new MessageSent($message->room_id, $message->user_id, $message->messages))->toOthers();

		return response('Message Sent!');
	}
	public function getMessages(){
		echo "hola";
	}
}
