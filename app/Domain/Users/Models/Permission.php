<?php

namespace SAASBoilerplate\Domain\Users\Models;

use SAASBoilerplate\App\Traits\Eloquent\Ordering\OrderableTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use OrderableTrait;

    protected $fillable = [
        'name',
        'usable'
    ];

    /**
     * The roles that belong to the permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withTimestamps();
    }
}
