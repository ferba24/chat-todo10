<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\RoomUser;
use App\Chat;
use App\XenUser;
//use App\PrivateChatUser;
//use App\PrivateChatUserChat;
use App\Traits\SessionTrait;
use Cookie;

class ApiController extends Controller{
	use SessionTrait;
	/* 
	API LOGIN
	return json($xen_user) // from XenUser
	*/
	public function login(Request $req) {
		$this->validate($req, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
		$xen_user = new XenUser;
		$xen_user = $xen_user->login(
			$req->input('username'),
			$req->input('password')
		);
		if(isset($xen_user->user)){
			$x_user = new XenUser;
			if($x_user->setUserById($xen_user->user)){
				return response()
						->json($xen_user)
						->cookie('xf_user', $xen_user->user->user_id, 30); //el número es minutos de vida de la cookie
			}else{
				return response()->json(json_encode([
					'error' => 'true'
				]));
			}
		}else{
			return response()->json($xen_user);
		}
	}
	// Check Login
	public function checkLogin(Request $req){
		$user_id = $this->getUserFromCookie($req);
		$ret = [
			"user_id" => intval($user_id),
			"timezone" => $this->getTimeZoneUser($user_id),
			"user_roles" => $this->getUserRoles($user_id)
		];
		return response()->json($ret);
	}
	// Check Room
	public function checkRoom(Request $req){
		return $this->getRoomLogin($req);
	}
	public function getCurrentUser(Request $req){
		$id = $this->getUserFromCookie($req);
		if($id && $id != 0){
			$x_u = new XenUser;
			$user = $x_u->getUserById($id);
			return response()->json($user->json);
		}
		return null;
	}
}
