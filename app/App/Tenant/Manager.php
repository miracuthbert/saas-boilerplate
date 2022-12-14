<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/28/2018
 * Time: 12:04 AM
 */

namespace SAAS\App\Tenant;

class Manager
{
    protected $tenant;

    /**
     * Get tenant.
     *
     * @return mixed
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * Set tenant.
     *
     * @param mixed $tenant
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;
    }
}