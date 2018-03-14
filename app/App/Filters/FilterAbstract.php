<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 12/20/2017
 * Time: 9:24 PM
 */

namespace SAASBoilerplate\App\Filters;


use Illuminate\Database\Eloquent\Builder;

abstract class FilterAbstract
{
    /**
     * Apply filter.
     *
     * @param Builder $builder
     * @param $value
     *
     * @return mixed
     */
    public abstract function filter(Builder $builder, $value);

    /**
     * Database value mappings.
     *
     * @return array
     */
    public function mappings()
    {
        return [];
    }

    /**
     * Database operator mappings.
     *
     * @return array
     */
    protected function operators()
    {
        return [];
    }

    /**
     * Resolve the value used for filtering.
     *
     * @param $key
     * @return mixed
     */
    protected function resolveFilterValue($key)
    {
        return array_get($this->mappings(), $key);
    }

    /**
     * Resolve the operator used for filtering.
     *
     * @param $key
     * @return mixed
     */
    protected function resolveFilterOperator($key)
    {
        return array_get($this->operators(), $key);
    }

    /**
     * Resolve the order direction to be used.
     *
     * @param $direction
     * @return mixed
     */
    protected function resolveOrderDirection($direction)
    {
        return array_get([
            'desc' => 'desc',
            'asc' => 'asc',
        ], $direction, 'desc');
    }
}