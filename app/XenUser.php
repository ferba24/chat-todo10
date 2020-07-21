<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use DB;

class XenUser{
	public function getUserById_Xenforo($id = null) {
		try{
			$client = new Client([
				'headers' => [
					'Accept' => 'application/json',
					'XF-Api-Key' => env('XENFORO_TOKEN')]
			]);		
			$res = $client->get(env('XENFORO_URL'). "users/$id/",
				['verify' => env('XENFORO_SSL')]);
			return json_decode((string) $res->getBody());
		}catch(\GuzzleHttp\Exception\RequestException $e){
	
		}
	}
	public function setUserById($user = null){
		if(!$user){
			return false;
		}
		$check_user = DB::table('xenusers')->where('user_id', $user->user_id)->first();
		if($check_user){
			DB::table('xenusers')
				->where('user_id', $user->user_id)
				->update([
					'json' => json_encode($user),
					'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
				]);
		}else{
			DB::table('xenusers')->insert([
				'user_id' => $user->user_id, 
				'json' => json_encode($user),
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
				'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
			]);
		}
		return true;
	}
	public function getUserById($id = null){
		if(!$id){
			return null;
		}
		return DB::table('xenusers')->where('user_id', $id)->first();
	}
	/*public function saveUser($username = null, $email = null, $password = null) {
		
		$client = new Client([
			'http_errors' => false,
			'headers' => [
				'Accept' => 'application/json',
				'XF-Api-User' => '1',
				'XF-Api-Key' => env('XENFORO_TOKEN')]
		]);		
		$res = $client->post(env('XENFORO_URL'). "users/?password=$password&username=$username&email=$email",
            ['verify' => env('XENFORO_SSL')]);
			
		return json_decode((string) $res->getBody());
	}*/
	public function login($username = '', $password = '') {
		$client = new Client([
			'http_errors' => false,
			'headers' => [
				'Accept' => 'application/json',
				'XF-Api-Key' => env('XENFORO_TOKEN')]
		]);		
		$res = $client->post(env('XENFORO_URL'). "auth/?password=$password&login=$username",
            ['verify' => env('XENFORO_SSL')]);
			
		return json_decode((string) $res->getBody());
	}
}
