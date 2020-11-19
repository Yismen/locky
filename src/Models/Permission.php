<?php

namespace Dainsys\Locky\Models;

use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    protected $fillable = ['name', 'guard_name'];
}
