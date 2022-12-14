<?php

namespace SAAS\Domain\Countries\Models;

use SAAS\Domain\Shipping\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'dial_code',
        'usable',
    ];

    /**
     * Get all shipping methods available for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class)->withTimestamps();
    }
}
