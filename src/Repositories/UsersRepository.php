<?php

namespace Dainsys\Locky\Repositories;

use App\User;
use Dainsys\Locky\Events\UserCreated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UsersRepository extends ModelRepositoryBase
{
    public static function all(): Collection
    {
        return Cache::rememberForever(self::$CACHE_KEYS[get_class(new self)], function () {
            info(self::$CACHE_KEYS[get_class(new self)]);
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

        $hashedPassword = Hash::make(request('password'));

        $user = User::create(array_merge(request()->all(), ['password' => $hashedPassword]));

        event(new UserCreated($user));

        return $user;
    }

    public static function update($user): Model
    {
        self::flushCache();
        $user->update(request()->all());

        if (request()->inactivated_at) {
            $user->inactivate(request()->inactivated_at);
        } else {
            $user->activate();
        }

        $user->roles()->sync((array) request('roles'));

        $user->permissions()->sync((array) request('permissions'));

        return $user;
    }

    public static function query()
    {
        return User::orderBy('name')
            ->with([
                'roles' => function ($query) {
                    return $query->orderBy('name');
                },
                'permissions' => function ($query) {
                    return $query->orderBy('name');
                },
            ]);
    }
}
