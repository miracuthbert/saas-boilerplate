<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/18/2018
 * Time: 7:05 PM
 */

namespace SAASBoilerplate\App\Traits\Eloquent\Ordering;


trait OrderableTrait
{
    /**
     * Order model results by latest first.
     *
     * @param $query
     * @return mixed
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * Order model results by latest delete.
     *
     * @param $query
     * @return mixed
     */
    public function scopeLatestDelete($query)
    {
        return $query->orderBy('deleted_at', 'DESC');
    }
}