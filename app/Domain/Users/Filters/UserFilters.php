<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/17/2018
 * Time: 12:02 PM
 */

namespace SAASBoilerplate\Domain\Users\Filters;


use SAASBoilerplate\App\Filters\FiltersAbstract;
use SAASBoilerplate\App\Filters\Ordering\CreatedOrder;
use SAASBoilerplate\Domain\Users\Models\Role;

class UserFilters extends FiltersAbstract
{
    protected $filters = [
        'role' => RoleFilter::class,
        'created' => CreatedOrder::class,
    ];

    protected $defaultFilters = [
        'created' => 'desc',
    ];

    /**
     * Create project filters map.
     *
     * @return array
     */
    public static function mappings()
    {
        //use view composer to render categories

        $map = [
            'created' => [
                'map' => [
                    'desc' => 'Latest',
                    'asc' => 'Older'
                ],
                'heading' => 'Date',
                'style' => 'list'
            ],
        ];

        //auth only filters
        if (auth()->check() && (auth()->user()->hasRole('admin-root') || auth()->user()->can('manage users'))) {
            $auth_map = [
                'role' => [
                    'map' => Role::get()->pluck('name', 'slug'),
                    'heading' => 'Roles',
                    'style' => 'list'
                ],
            ];

            $map = array_merge($map, $auth_map);
        }

        return $map;
    }
}