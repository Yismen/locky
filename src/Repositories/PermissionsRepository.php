<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Permission;

class PermissionsRepository implements ModelRepositoryInterface
{
    public static function all()
    {
        return Permission::orderBy('name')->with('roles', 'users')->get();
    }
}
