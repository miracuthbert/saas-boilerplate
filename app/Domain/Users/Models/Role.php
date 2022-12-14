<?php

namespace SAAS\Domain\Users\Models;

use SAAS\App\Traits\Eloquent\Ordering\OrderableTrait;
use SAAS\App\Traits\Eloquent\Ordering\PivotOrderableTrait;
use SAAS\Domain\Users\Filters\Roles\RoleFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends \Miracuthbert\LaravelRoles\Models\Role
{
    use OrderableTrait, PivotOrderableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expires_at'];

    /**
     * The attributes that should be cast.     
     * 
     * @var array     
     */
    protected $casts = [
        'usable' => 'boolean',
    ];

    /**
     * Sets role order based on node.
     *
     * @param $order
     * @param $node
     * @return $this
     */
    public function setRoleOrder($order, $node)
    {
        if ($node == $this->id) {
            return $this;
        }

        $node = Role::find($node);

        switch ($order):
            case 'child':
                $this->parent()->associate($node);
                break;

            case 'after':
                $this->afterNode($node);
                break;

            case 'before':
                $this->beforeNode($node);
                break;
        endswitch;

        return $this;
    }

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
