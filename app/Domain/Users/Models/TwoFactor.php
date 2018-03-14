<?php

namespace SAASBoilerplate\Domain\Users\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
    protected $table = 'two_factor';

    protected $fillable = [
        'phone',
        'dial_code',
        'identifier',
        'verified'
    ];

    /**
     *  Booting of model
     *
     * Delete any previous two factor.
     */
    public static function boot()
    {
        static::creating(function ($twoFactor) {
            optional($twoFactor->user->twoFactor)->delete();
        });
    }

    /**
     * Check whether the phone is verified.
     *
     * @return mixed
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * Get the two factor user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
