<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\RoomUser;
use App\Chat;
use App\XenUser;
use App\PrivateChatUser;
use App\PrivateChatUserChat;
use Cookie;

class ApiController extends Controller{
    //
	public function getUser($room = '', $search = '') {	
		if($room != '') {
			$users = RoomUser::where('room_id', $room)->get();
			if(isset($users)) {
				$sessions = \DB::table('sessions')->get();
				foreach($users as $key => $u) {
					$xen_user = new XenUser();
					$xen_user = $xen_user->getUserById($u->user_id);
					if($xen_user){
						$u->json = json_encode($xen_user);
						$u->save();
					}
					foreach($sessions as $s){
						$payload = unserialize(base64_decode($s->payload));
						$now = \Carbon\Carbon::now();
						$dateSession = \Carbon\carbon::createFromTimestamp($s->last_activity);
						if(isset($payload['user'])){
							if($payload['user'] == $u->user_id){
								// Comprueba si el usuario todavía está activo hace 1 minuto
								if($now->diffInMinutes($dateSession) >= 1 ){
									unset($users[$key]);
								}
							}
							//Se valida la sesión y si tiene más de 10 minutos se borrará
							if($now->diffInMinutes($dateSession) >= 10){
								\DB::table('sessions')->where('id', $s->id)->delete();
							}
							/**
							 * Arreglar la parte d eque está eliminado la sesión de la DB y aún sigue
							 * apareciendo el usuario root, porque no se compara y mejor
							 * Poner en el room_user una columna active para no hacer tantas validaciones
							 */
						}
					}
				}
			
				return response()->json($users);
			}
		} 
	}
	
	//
	public function getUserPrivate() {	
		$user = PrivateChatUser::where('user_id', session('user'))->get();		
		
		$users = array();
		foreach($user AS $u) {
			$xen_user = new XenUser();
			$xen_user = $xen_user->getUserById($u->user_private_id);
			
			array_push($users, $xen_user);
		}
		
		return response()->json($users);
	}
	
	//
	public function getUserPrivateChat($user) {	
	
		$user = PrivateChatUserChat::select('private_chat_user_chat.messages', 'private_chat_user_chat.user_id', 'private_chat_user_chat.created_at')->
			join('private_chat_user', 'private_chat_user.id', 'private_chat_user_chat.private_chat_user_id')->
			where('private_chat_user.user_id', session('user'))->get();	
		
		return response()->json($user);
	}
	
	//
	public function getMessages($room = '') {
		$chat = Chat::where('room_id', $room)->orderBy('id', 'asc')->get();
		//		
		foreach($chat AS $c) {
			$xen_user = new XenUser();
			$xen_user = $xen_user->getUserById($c->user_id);
			$c->json = json_encode($xen_user);
			$c->update();
		}
		return response()->json($chat);
	}
	
	// 
	public function getCountUsers($room = '') {
		$count_users = RoomUser::join('room', 'room.id', '=', 'room_user.room_id')
				->where('room_user.room_id', '=', $room)->count();
		return response()->json($count_users);
	}
	
	//
	public function saveUsers(Request $request) {
		
		$this->validate($request, [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);
		
		$xen_user = new XenUser();
		$xen_user = $xen_user->saveUser(
			$request->input('username'),
			$request->input('email'),
			$request->input('password'));

        return response()->json($xen_user);
	}
	
	//
	public function login(Request $request) {
		$this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
		$xen_user = new XenUser();
		$xen_user = $xen_user->login(
			$request->input('username'),
			$request->input('password')
		);
        return response()->json($xen_user)->cookie('xf_user', $xen_user->user->user_id);
	}
	
	//
	public function updateUser() {
		
	}
}
