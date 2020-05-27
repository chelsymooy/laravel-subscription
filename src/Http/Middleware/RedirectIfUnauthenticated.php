<?php

namespace Chelsymooy\Subscriptions\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Chelsymooy\Subscriptions\Providers\SubscriptionServiceProvider;

class RedirectIfUnauthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }
        
        return redirect(SubscriptionServiceProvider::HOME);
    }
}
