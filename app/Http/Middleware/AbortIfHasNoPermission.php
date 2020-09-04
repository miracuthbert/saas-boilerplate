<?php

namespace SAASBoilerplate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AbortIfHasNoPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure  $next
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
