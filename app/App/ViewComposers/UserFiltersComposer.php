<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/17/2018
 * Time: 12:44 PM
 */

namespace SAASBoilerplate\App\ViewComposers;

use SAASBoilerplate\Domain\Users\Filters\UserFilters;
use Illuminate\View\View;

class UserFiltersComposer
{
    public function compose(View $view)
    {
        return $view->with([
            'users_mappings' => UserFilters::mappings(),
        ]);
    }
}