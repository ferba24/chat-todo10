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
        if($req->session()->get('user') == $user){
            return $next($req);
        }
    }
}
