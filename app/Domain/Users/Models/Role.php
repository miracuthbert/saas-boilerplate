<?php

namespace SAASBoilerplate\Domain\Users\Models;

use SAASBoilerplate\App\Traits\Eloquent\Ordering\OrderableTrait;
use SAASBoilerplate\App\Traits\Eloquent\Ordering\PivotOrderableTrait;
use SAASBoilerplate\Domain\Users\Filters\Roles\RoleFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Role extends Model
{
    use NodeTrait, OrderableTrait, PivotOrderableTrait;

    protected $fillable = [
        'name',
        'slug',
        'details',
        'usable'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expires_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Filters the result.
     *
     * @param Builder $builder
     * @param $request
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new RoleFilters($request))->add($filters)->filter($builder);
    }

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->using(UserRole::class)
            ->withTimestamps()
            ->withPivot(['expires_at']);
    }

    /**
     * The permissions that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }
}
