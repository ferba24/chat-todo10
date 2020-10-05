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
		return view('home');
    }
	public function logout(Request $req) {
		unset($_COOKIE['xf_user']);
		$req->session()->forget(['user', 'room']);
		$req->session()->flush();
		return redirect()->route('home')->withCookie(\Cookie::forget('xf_user'));
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
