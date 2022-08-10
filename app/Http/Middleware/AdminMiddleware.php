<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard='admin')
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->intended('/admin');
            // return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
    }
}
