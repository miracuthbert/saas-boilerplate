<?php

namespace SAASBoilerplate\Domain\Subscriptions\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'gateway_id',
        'price',
        'active',
        'teams_enabled',
        'teams_limit',
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
     * Check if plan is for teams.
     *
     * @return bool
     */
    public function isForTeams()
    {
        return $this->teams_enabled;
    }

    /**
     * Check if plan is not for teams.
     *
     * @return bool
     */
    public function isNotForTeams()
    {
        return !$this->isForTeams();
    }

    /**
     * Get active plans.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }

    /**
     * Get plans except passed.
     *
     * @param Builder $builder
     * @param $planId
     * @return mixed
     */
    public function scopeExcept(Builder $builder, $planId)
    {
        return $builder->where('id', '!=', $planId);
    }

    /**
     * Get plans for users.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeForUsers(Builder $builder)
    {
        return $builder->where('teams_enabled', false);
    }

    /**
     * Get plans for teams.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeForTeams(Builder $builder)
    {
        return $builder->where('teams_enabled', true);
    }
}
