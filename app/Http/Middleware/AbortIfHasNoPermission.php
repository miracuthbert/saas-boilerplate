<?php

namespace SAAS\Http\Middleware;

use Closure;

class AbortIfHasNoPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        if (!$request->user()->can($permission)) {
            return abort(404);
        }

        return $next($request);
    }
}
