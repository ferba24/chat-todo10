<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Room;
use App\RoomUser;
use App\XenUser;

class RoomController extends Controller{
	public function index() {
		
	}
	public function selected(Request $req, $room = '') {
		// Add user to room
		$rooms = RoomUser::where('room_id', $room)->where('user_id', $req->session()->get('user'))->first();
		if(!$rooms) {
			$roomUser = new RoomUser();
			$roomUser->user_id = $req->session()->get('user');
			$roomUser->room_id = $room;
			$roomUser->save();
		}
		$req->session()->put('room', $room);
		return redirect()->route('home')->with('success', 'Se ha creado satisfactoriamente!');
	}	
	public function change(Request $req, $room = '') {
		$room = RoomUser::where("room_id", $room)->where('user_id', $req->session()->get('user'))->first();
		if($room) {
			$req->session()->put('room', $room->room_id);
		}	
		return redirect()->route('home')->with('success', 'Se ha creado satisfactoriamente!');
	}
	//
	public function exitRoom(Request $req, $room = null) {
		$room = RoomUser::where("room_id", $room)->where('user_id', $req->session()->get('user'))->first();
		$room->delete();
		return redirect()->route('home')->with('success', 'Se ha creado satisfactoriamente!');
	}
	//
	public function getRooms() {
		$rooms = \DB::table('room')->where('room.id', '!=', 1)
				->leftJoin('room_user', 'room.id', 'room_user.room_id')
				->select('room.*', \DB::raw('(SELECT COUNT(*) FROM room_user WHERE room.id = room_user.room_id) as count_room'))
				->groupBy('room.id')
				->orderBy('count_room', 'desc')->get();
		return response($rooms->toJson());
	}
	public function getRoomsUser($id = null){
		if(!$id){
			return null;
		}
		$rooms = \DB::table('room_user')->where('room_id', '!=', 1)->where('user_id', $id)->get();
		return response($rooms->toJson());
	}
	
}
