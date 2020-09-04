<?php

namespace SAASBoilerplate\Http\Middleware\Subscription;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('account.index');
        }

        return $next($request);
    }
}
