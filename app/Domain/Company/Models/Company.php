<?php

namespace SAAS\Domain\Company\Models;

use Illuminate\Database\Eloquent\Model;
use SAAS\App\Tenant\Traits\IsTenant;
use SAAS\Domain\Project\Models\Project;

class Company extends Model
{
    use IsTenant;

    protected $fillable = [
        'name',
        'country',
        'email',
        'phone'
    ];

    /**
     * Get projects owned by company.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
