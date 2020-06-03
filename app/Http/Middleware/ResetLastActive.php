<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class ResetLastActive
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
        Session::put('lastActive',date('U'));
        Session::forget('idleWarningDisplayed');
        Session::forget('logoutWarningDisplayed');
        return $next($request);
    }
}
