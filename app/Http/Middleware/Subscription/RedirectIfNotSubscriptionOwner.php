<?php

namespace SAAS\Http\Middleware\Subscription;

use Closure;

class RedirectIfNotSubscriptionOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasPiggybackSubscription()) {
            return redirect()->route('account.index');
        }

        return $next($request);
    }
}
