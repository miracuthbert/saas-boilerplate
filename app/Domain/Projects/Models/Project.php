<?php

namespace SAASBoilerplate\Domain\Projects\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SAASBoilerplate\App\Tenant\Traits\ForTenants;

class Project extends Model
{
    use Sluggable,
        ForTenants;

    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
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
     * Scope a query to exclude 'tenant' scope.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithoutForTenants(Builder $builder)
    {
        return $builder->withoutGlobalScope(ForTenants::class);
    }
}
