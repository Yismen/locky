<?php

namespace Dainsys\Locky\Repositories;

use App\User;

class UsersRepository implements ModelRepositoryInterface
{
    public static function all()
    {
        return User::orderBy('name')->get();
    }
}
