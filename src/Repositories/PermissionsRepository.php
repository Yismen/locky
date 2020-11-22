<?php

namespace Dainsys\Locky\Repositories;

use Dainsys\Locky\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PermissionsRepository extends ModelRepositoryBase
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

        return Permission::create(request()->all());
    }

    public static function update($permission): Model
    {
        self::flushCache();

        $permission->update(request()->all());

        $permission->users()->sync(request('users'));

        $permission->roles()->sync(request('roles'));

        return $permission;
    }

    protected static function query()
    {
        return Permission::orderBy('name')->with([
            'roles' => function ($query) {
                return $query->orderBy('name');
            },
            'users' => function ($query) {
                return $query->orderBy('name');
            },
        ]);
    }
}
