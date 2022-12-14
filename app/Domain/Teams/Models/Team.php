<?php

namespace SAAS\Domain\Teams\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\Domain\Users\Models\User;
use Miracuthbert\Multitenancy\Traits\IsTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model implements Tenant
{
    use Sluggable,
        HasFactory,
        IsTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'domain',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'domain' => [
                'source' => ['name'],
            ],
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
