<?php
namespace App\Http\Middleware;
use Closure;

class ApiConnect{
    public function handle($request, Closure $next){
        if( !$request->get('_api_token') && $request->get('_api_token') != env('API_CONNECT') ){
            abort(404);
        }
        return $next($request);
    }
}
