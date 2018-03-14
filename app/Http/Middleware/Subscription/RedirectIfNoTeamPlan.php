<?php

namespace SAASBoilerplate\Http\Middleware\Subscription;

use Closure;

class RedirectIfNoTeamPlan
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
        if(auth()->user()->doesNotHaveTeamSubscription()){
            return redirect()->route('account.index')
                ->withSuccess('You need to have a team subscription to access team features.');
        }

        return $next($request);
    }
}
