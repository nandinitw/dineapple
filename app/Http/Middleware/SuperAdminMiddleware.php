<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class SuperAdminMiddleware
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
        $role = Auth::user()->role;
        if($role == 1){
            return $next($request);     
        }else{
            return Redirect::to('/home')->with('error','Access Denied');
        }
       
    }
}
