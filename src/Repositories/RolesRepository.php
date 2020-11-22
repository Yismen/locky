<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class RolesRepository extends ModelRepositoryBase
{
    public static function all(): Collection
    {
        return Cache::rememberForever(self::$CACHE_KEYS[get_class(new self)], function () {
            return self::query()->get();
        });
    }
    public static function paginate(int $amount = 15)
    {
        return self::query()->paginate($amount);
    }

    public static function store(): Model
    {
        self::flushCache();

        $role = Role::create(request()->all());

        return $role;
    }

    public static function update($role): Model
    {
        self::flushCache();

        $role->update(request()->all());

        $role->users()->sync(request('users'));

        $role->permissions()->sync(request('permissions'));

        return $role->load('users', 'permissions');
    }

    protected static function query()
    {
        return Role::orderBy('name')->with([
            'users' => function ($query) {
                return $query->orderBy('name');
            },
            'permissions' => function ($query) {
                return $query->orderBy('name');
            }
        ]);
    }
}
