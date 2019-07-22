<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class OutletAdminMiddleware
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
        
        if(Auth::user()->role == 2){
            $request['outlet'] = Auth::user()->outlet_id;
            $request['hotel'] = Auth::user()->outlet->hotel->id;
            $request['is_outletadmin'] = 1;
            return $next($request);
        }elseif(Auth::user()->role == 1) {
            //$request['outlet'] = "";
            //$request['hotel'] = "";
            $request['is_outletadmin'] = 0;
            return $next($request);
        }else{
            return Redirect::to('/home')->with('error','Access Denied');
        }
       
    }
}
