<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Permission;

class PermissionsRepository implements ModelRepositoryInterface
{
    public static function all()
    {
        return Permission::orderBy('name')->with([
            'roles' => function ($query) {
                return $query->orderBy('name');
            },
            'users' => function ($query) {
                return $query->orderBy('name');
            },
        ])->get();
    }
}
