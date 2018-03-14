<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/17/2018
 * Time: 12:05 PM
 */

namespace SAASBoilerplate\Domain\Users\Filters;


use SAASBoilerplate\App\Filters\FilterAbstract;
use SAASBoilerplate\Domain\Users\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class RoleFilter extends FilterAbstract
{

    /**
     * Apply filter.
     *
     * @param Builder $builder
     * @param $value
     *
     * @return mixed
     */
    public function filter(Builder $builder, $value)
    {
        if($value === null) {
            return $builder;
        }

        $role = Role::with(['descendants'])
            ->where('slug', $value)->first();

        $roles = $role
            ->descendants->pluck('id')->prepend($role->id);

        return $builder->whereHas('roles', function (Builder $builder) use ($roles) {
            $builder->whereIn('role_id', $roles);
        });
    }
}