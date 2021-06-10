<?php

namespace Dainsys\Locky\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class ModelRepositoryBase
{
    protected static $CACHE_KEYS = [
        PermissionsRepository::class => 'locky.permissions',
        RolesRepository::class => 'locky.roles',
        UsersRepository::class => 'locky.users',
    ];

    abstract public static function all(): Collection;

    abstract public static function paginate(int $amount = 15);

    abstract public static function store(): Model;

    abstract public static function update(Model $model): Model;

    abstract protected static function query();

    public static function flushCache()
    {
        foreach (self::$CACHE_KEYS as $key) {
            Cache::forget($key);
        }
    }
}
