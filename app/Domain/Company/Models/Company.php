<?php

namespace SAASBoilerplate\Domain\Company\Models;

use Illuminate\Database\Eloquent\Model;
use SAASBoilerplate\App\Tenant\Traits\IsTenant;
use SAASBoilerplate\Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
