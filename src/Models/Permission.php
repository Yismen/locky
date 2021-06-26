<?php

namespace Dainsys\Locky\Models;

use Spatie\Permission\Models\Permission as ModelsPermission;
use Illuminate\Support\Str;

class Permission extends ModelsPermission
{
    protected $fillable = ['name', 'guard_name'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = Str::of($name)->trim()->title()->__toString();
    }
}
