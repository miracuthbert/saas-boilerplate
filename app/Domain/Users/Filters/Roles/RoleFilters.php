<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/18/2018
 * Time: 1:46 PM
 */

namespace SAASBoilerplate\Domain\Users\Filters\Roles;


use SAASBoilerplate\App\Filters\FiltersAbstract;
use SAASBoilerplate\App\Filters\Ordering\CreatedOrder;
use SAASBoilerplate\Domain\Users\Filters\PermissionFilter;
use SAASBoilerplate\Domain\Users\Models\Permission;

class RoleFilters extends FiltersAbstract
{
    protected $filters = [
        'permission' => PermissionFilter::class,
        'created' => CreatedOrder::class,
    ];

    protected $defaultFilters = [
        //
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
        if (auth()->check() && (auth()->user()->can('manage blog'))) {
            $auth_map = [
                'permission' => [
                    'map' => Permission::get()->pluck('name', 'id'),
                    'heading' => 'Permissions',
                    'style' => 'list'
                ],
            ];

            $map = array_merge($map, $auth_map);
        }

        return $map;
    }
}