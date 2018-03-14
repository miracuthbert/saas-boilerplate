<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/18/2018
 * Time: 1:49 PM
 */

namespace SAASBoilerplate\Domain\Users\Filters;


use SAASBoilerplate\App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class PermissionFilter extends FilterAbstract
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
        if ($value === null) {
            return $builder;
        }

        return $builder->whereHas('permissions', function (Builder $builder) use ($value) {
            return $builder->where('permission_id', $value);
        });
    }
}