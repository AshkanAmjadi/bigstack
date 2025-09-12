<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminFliter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ( $request->user()->is_superuser() || $request->user()->is_staff() || $request->user()->is_boss()){

            return $next($request);

        }else{

            return redirect('/');

        }


    }
}
