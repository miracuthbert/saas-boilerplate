<?php

namespace SAASBoilerplate\Http\Middleware\Subscription;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->doesNotHaveSubscription()) {
            return redirect()->route('account.index')
                ->with('success', 'You need to be subscribed to access this feature.');
        }

        return $next($request);
    }
}
