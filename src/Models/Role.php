<?php

namespace Dainsys\Locky\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    protected $fillable = ['name', 'guard_name'];
}
