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
        if(Auth::user()->verified == 0 && !\Request::is('verified')) {
            return redirect()->route('verified.email');
        } else if(Auth::user()->verified == 1 && \Request::is('verified')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
