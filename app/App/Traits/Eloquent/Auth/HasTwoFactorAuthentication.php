<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 3/9/2018
 * Time: 12:21 PM
 */

namespace SAASBoilerplate\App\Traits\Eloquent\Auth;

use SAASBoilerplate\Domain\Users\Models\TwoFactor;

trait HasTwoFactorAuthentication
{
    /**
     * Set user two-factor relationship.
     *
     * @return mixed
     */
    public function twoFactor()
    {
        return $this->hasOne(TwoFactor::class);
    }

    /**
     * Check whether user verification is pending.
     *
     * @return bool
     */
    public function twoFactorPendingVerification()
    {
        if (!$this->twoFactor) {
            return false;
        }

        return !$this->twoFactor->isVerified();
    }

    /**
     * Check whether user has enabled two-factor auth.
     *
     * @return bool
     */
    public function twoFactorEnabled()
    {
        return (bool)optional($this->twoFactor)->isVerified();
    }
}