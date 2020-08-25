<?php

namespace SAASBoilerplate\Http\Middleware\Subscription;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNoTeamPlan
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
        if(auth()->user()->doesNotHaveTeamSubscription()){
            return redirect()->route('account.index')
                ->with('success', 'You need to have a team subscription to access team features.');
        }

        return $next($request);
    }
}
