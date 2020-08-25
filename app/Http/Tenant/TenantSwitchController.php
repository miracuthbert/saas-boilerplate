<?php

namespace SAASBoilerplate\Http\Tenant;

use Illuminate\Http\RedirectResponse;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Company\Events\CompanyUserLogin;
use SAASBoilerplate\Domain\Company\Models\Company;

class TenantSwitchController extends Controller
{
    /**
     * Switch tenant.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function switch(Company $company)
    {
        event(new CompanyUserLogin(
            request()->user(),
            $company
        ));

        return redirect()->route('tenant.dashboard');
    }
}
