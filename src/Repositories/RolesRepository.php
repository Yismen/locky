<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Role;

class RolesRepository implements ModelRepositoryInterface
{
    public static function all()
    {
        return Role::orderBy('name')->get();
    }
}
