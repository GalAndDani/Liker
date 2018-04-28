<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActivation
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
        if(Auth::user()->verified == 0 && !\Request::is('unverified')) {
            return redirect()->route('unverified');
        } else if(Auth::user()->verified == 1 && \Request::is('unverified')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
