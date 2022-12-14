<?php

namespace SAAS\Http\Middleware;

use Closure;

class AbortIfHasNoRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!$request->user()->hasRole($role)) {
            return abort(404);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            return abort(404);
        }

        return $next($request);
    }
}
