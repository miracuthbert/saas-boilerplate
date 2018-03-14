<?php

namespace SAASBoilerplate\Domain\Teams\Models;

use Illuminate\Database\Eloquent\Model;
use SAASBoilerplate\Domain\Users\Models\User;

class Team extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Get user that owns of team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get users that belong to team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users')
            ->withTimestamps();
    }
}
