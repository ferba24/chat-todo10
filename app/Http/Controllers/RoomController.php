<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Room;
use App\RoomUser;
use App\XenUser;

class RoomController extends Controller{
	// Get all rooms
	public function getRooms() {
		$rooms = \DB::table('room')
						//->select('room.*', \DB::raw('0 as count_room'))
						->orderBy('room.room_name', 'desc')->get();
		return response($rooms->toJson());
	}
	public function getRoomsByUser($room_id = null){
		if(is_null($room_id)){
			return null;
		}
		$rooms = \DB::table('room_user')->where('room_id', $room_id)->get();
		return response($rooms->toJson());
	}
	//Se selecciona un usuario al room indicado por $req
	public function select(Request $req) {
		// Add user to room
		if($req->get('room_id')){
			$rooms = RoomUser::where('room_id', $req->get('room_id'))->where('user_id', $req->session()->get('user'))->first();
			if(!$rooms) {
				$roomUser = new RoomUser();
				$roomUser->user_id = $req->session()->get('user');
				$roomUser->room_id = $req->get('room_id');
				$roomUser->save();
			}
			$req->session()->put('room', $req->get('room_id'));
			return response(json_encode([
				'success' => 'Se ha añadido al usuario al room',
				'room_id' => $req->get('room_id')
			]));
		}else{
			return response(json_encode([
				'error' => 'room_id es requerido'
			]));
		}
	}
	//Obtener los rooms de un usuario
	public function getFromUser(Request $req){
		$rooms = \DB::table('room_user')
					->where('room_user.user_id', $req->session()->get('user'))
					->leftJoin('room', 'room.id', '=', 'room_user.room_id')
					->select('room.room_name as room_name', 'room.id as id')
					->get();
		return response($rooms->toJson());
	}
	//Salir de una sala
	public function exitRoom(Request $req) {
		$room = RoomUser::where("room_id", $req->get('room_id'))->where('user_id', $req->session()->get('user'))->first();
		if($room){
			$room->delete();
			return response(json_encode([
				'success' => 'Se ha borrado al usuario del room'
			]));
		}
		return response(json_encode([
			'error' => 'No se borró el usuario del room porque no existe esa relación'
		]));
	}
	public function getRoom($id = null){
		if(is_null($id)){
			return response(json_encode([
				'error' => '$id es null'
			]));
		}
		$room = Room::where('id', $id)->first();
		if(!$room){
			return response(json_encode([
				'error' => 'No existe el room'
			]));
		}
		return response($room->toJson());
	}
}
