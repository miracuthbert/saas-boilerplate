<?php

namespace SAAS\Http\Middleware\Tenant;

use Closure;

class TenantConfigMiddleware
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
        $tenant = $request->tenant();

        config()->set('app.name', $tenant->name);

        return $next($request);
    }
}
