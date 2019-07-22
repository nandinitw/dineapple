<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;

class CheckRole
{
    public function handle($request, Closure $next)
    {
        $accsee_role = array('1','2');
        //if (Auth::user()->role == 1 || Auth::user()->role == 2 ) {
        if ( !in_array( Auth::user()->role, $accsee_role ) )  {
            return Redirect::to('/home');
        }

        return $next($request);
    }
}
