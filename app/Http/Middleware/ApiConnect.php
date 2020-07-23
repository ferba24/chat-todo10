<?php
namespace App\Http\Middleware;
use App\Traits\SessionTrait;
use Closure;

class ApiConnect{
    use SessionTrait;

    public function handle($req, Closure $next){
        $user = $this->getUserFromCookie($req);
        if(!$user){
            abort(404);
        }
        $sessions = \DB::table('sessions')->get();
		foreach($sessions as $s){
			$payload = unserialize(base64_decode($s->payload));
			if(isset($payload['user']) && $payload['user'] == $user ){
                return $next($req);
			}
		}
    }
}
