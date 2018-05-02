<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/27/2018
 * Time: 7:04 PM
 */

namespace SAASBoilerplate\App\Tenant\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * @var Model
     */
    protected $tenant;

    /**
     * TenantScope constructor.
     * @param Model $tenant
     */
    public function __construct(Model $tenant)
    {
        $this->tenant = $tenant;
    }

    public function apply(Builder $builder, Model $model)
    {
        return $builder->where($this->tenant->getForeignKey(), '=', $this->tenant->id);
    }
}