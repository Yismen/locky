<?php

namespace Dainsys\Locky\Models;

use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Support\Str;

class Role extends ModelsRole
{
    protected $fillable = ['name', 'guard_name'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = Str::of($name)->trim()->title()->__toString();
    }
}
