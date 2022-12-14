<?php

namespace SAAS\Domain\Users\Models;

use SAAS\App\Traits\Eloquent\Ordering\OrderableTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Miracuthbert\LaravelRoles\Models\Permission
{
    use OrderableTrait;
}
