<?php

namespace App\Http\Middleware;

use App\Helpers\Mws;
use Closure;

class CheckDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mws = Mws::instance($request);
        
        if(!$mws -> store){
            abort(404);
        }else{
            return $next($request);
        }
    }   
}
