<?php

namespace SAASBoilerplate\Domain\Teams\Models;

use Illuminate\Database\Eloquent\Model;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Get user that owns of team.
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get users that belong to team.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users')
            ->withTimestamps();
    }
}
