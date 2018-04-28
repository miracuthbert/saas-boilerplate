<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/27/2018
 * Time: 6:25 PM
 */

namespace SAASBoilerplate\App\Tenant\Traits;

use Ramsey\Uuid\Uuid;

trait IsTenant
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            $tenant->uuid = Uuid::uuid4();  // TODO: Switch uuid with webpatser/uuid package
        });
    }
}