<?php

namespace SAASBoilerplate\Domain\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = 'user_roles';

    protected $dates = [
        'expires_at'
    ];

    /**
     * Return true if role is still valid.
     *
     * @return bool
     */
    public function isActive()
    {
        return Carbon::now()->lt($this->expires_at);
    }
}
