<?php

namespace SAASBoilerplate\Http\Middleware\Tenant;

use Closure;
use SAASBoilerplate\App\Tenant\Manager;
use SAASBoilerplate\Domain\Company\Models\Company;

class TenantMiddleware
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
        // alternative way to resolve tenant based on last login access
        // uncomment lines below and remove the used ones
        // remember: change the routes in your views to reflect the new ones
        // new switch route name: tenant.switch params: {company}
        // new dashboard route name: tenant.dashboard params: none

        // $tenant = $this->resolveTenant(
        //    $request->company ?:
        //        auth()->check() ? auth()->user()->lastAccessedCompany->id : session()->get('tenant')
        // );

        $tenant = $this->resolveTenant(
            $request->company ?: session()->get('tenant')
        );

        if (!auth()->user()->companies->contains('id', $tenant->id)) {
            return redirect('/account/dashboard');
        }

        $this->registerTenant($tenant);

        return $next($request);
    }

    /**
     * Register the given tenant to the app container
     * through the tenant manager.
     *
     * @param $tenant
     */
    protected function registerTenant($tenant)
    {
        app(Manager::class)->setTenant($tenant);

        session()->put('tenant', $tenant->id);
    }

    /**
     * Find passed tenant (in this case a company) by id.
     *
     * @param $id
     * @return mixed
     */
    protected function resolveTenant($id)
    {
        return Company::findOrFail($id);
    }
}
