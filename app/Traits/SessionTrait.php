<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait SessionTrait {
    /*
	API SET COOKIE & SESSION
	return $user (int)
	*/
    public function getUserFromCookie(Request $req) {
        if(isset($_COOKIE["xf_user"]) && (\Cookie::get('xf_user') == null)) {
			$xf_user = $_COOKIE["xf_user"];
			$pos = strpos($xf_user, ',');
			$user = substr($xf_user,0,$pos);
			$req->session()->put('user', $user);
		}else{
			if (\Cookie::get('xf_user') !== null) {
				$user = \Cookie::get('xf_user');
				$req->session()->put('user', $user);
			} else {
				$user = null;
			}
		}
		return $user;
    }
    // API GET ROOM BEFORE LOGIN
	public function getRoomLogin(Request $req){
        return ($req->session()->get('user'))?$req->session()->get('room'):null;
	}
}