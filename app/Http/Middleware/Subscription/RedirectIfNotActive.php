<?php

namespace SAAS\Http\Middleware\Subscription;

use Closure;

class RedirectIfNotActive
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
        if (auth()->check() && auth()->user()->doesNotHaveSubscription()) {
            return redirect()->route('account.index')
                ->withSuccess('You need to be subscribed to access this feature.');
        }

        return $next($request);
    }
}
