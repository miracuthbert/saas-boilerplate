<?php

namespace SAASBoilerplate\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;

class TenantConfigMiddleware
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
        $tenant = $request->tenant();

        config()->set('app.name', $tenant->name);

        return $next($request);
    }
}
