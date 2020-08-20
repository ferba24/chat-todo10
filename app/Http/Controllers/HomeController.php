<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\XenUser;
use App\Room;
use App\RoomUser;
use App\Traits\SessionTrait;

class HomeController extends Controller{
	use SessionTrait;

    public function index(Request $req){
		/*echo \Cookie::get('XSRF-TOKEN');
		echo "<br>";
		$sessions = \DB::table('sessions')->get();
		foreach($sessions as $s){
			$payload = unserialize(base64_decode($s->payload));
			if(isset($payload['user'])){
				var_dump($payload);
				$now = \Carbon\Carbon::now();
				$dateSession = \Carbon\carbon::createFromTimestamp($s->last_activity);
				var_dump($now);
				var_dump($dateSession);
				echo $now->diffInMinutes($dateSession);
			}
		}
		exit(1);*/
		/*
		Se busca la cookie del usuario para validar si está logeado o no
		desde SessionTrait->getUserFromCookie
		*/
		/*$user = $this->getUserFromCookie($req);
		// Si está logeado
		if($user) {
			// Api xenforo
			$X_user = new XenUser();
			//Se obtiene el usuario desde la api de xenforo
			$user = $X_user->getUserById_Xenforo($user);
			if(isset($user->user) && $user->user){
				$user = $user->user;
				// se actualiza la información del usuario en laravel
				$X_user->setUserById($user);
			}
			//Se revisa que el usuario está regstrado en el room 1 general
			$check_r_u = RoomUser::where('user_id', $user->user_id)->where('room_id', 1)->first();
			if(!$check_r_u){
				$new_r_u = new RoomUser;
				$new_r_u->user_id = $user->user_id;
				$new_r_u->room_id = 1;
				$new_r_u->save();
			}
			// Room by user
			$rooms = RoomUser::join('room', 'room.id', '=', 'room_user.room_id')
					->where('room_user.user_id', '=', $user->user_id)->get();
			// Room selected		
			/*$selected = RoomUser::join('room', 'room.id', '=', 'room_user.room_id')
					->where('room_user.user_id', '=', $user->user_id)
					->where('room_user.select', '=', '1')->first();*/
			// Users
			/*if($selected){
				// Count Rooms
				$count_rooms = RoomUser::join('room', 'room.id', '=', 'room_user.room_id')
					->where('room_user.user_id', '=', $user->user_id)->count();
			}else{
				$count_rooms = null;
			}*/
			//Obtiene el room actual del usuario
			/*$sessionRoom = $req->session()->get('room');
			$xen_user = $user;
			return view('home', compact('xen_user', 'rooms', 'sessionRoom'));
		}else{*/
			return view('home');
		//}
    }
	public function logout() {
		\Cookie::forget('xf_user');
		unset($_COOKIE['xf_user']); 
		setcookie('xf_user', null, -1, '/'); 
		return redirect()->route('home')->with('success', 'Se ha creado satisfactoriamente!');
	}
	public function offsetTimezone(Request $req){
		$origin_dtz = new \DateTimeZone($req->get('tz1'));
		$remote_dtz = new \DateTimeZone($req->get('tz2'));
		$origin_dt = new \DateTime("now", $origin_dtz);
		$remote_dt = new \DateTime("now", $remote_dtz);
		$offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
		return ($offset/60)/60;
	}
}
