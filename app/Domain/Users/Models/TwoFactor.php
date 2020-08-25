<?php

namespace SAASBoilerplate\Domain\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($twoFactor) {
            // delete any previously available two factor authorization
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
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
