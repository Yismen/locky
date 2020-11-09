<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Role;

class RolesRepository implements ModelRepositoryInterface
{
    public static function all()
    {
        return Role::orderBy('name')->with([
            'users' => function ($query) {
                return $query->orderBy('name');
            },
            'permissions' => function ($query) {
                return $query->orderBy('name');
            }
        ])->get();
    }
}
