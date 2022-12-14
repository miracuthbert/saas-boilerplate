<?php

namespace SAAS\Http\Tenant;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Company\Events\CompanyUserLogin;
use SAAS\Domain\Company\Models\Company;

class TenantSwitchController extends Controller
{
    /**
     * Switch tenant.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
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
