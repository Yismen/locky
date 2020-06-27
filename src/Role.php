<?php

namespace Dainsys\Locky;

use App\User;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    protected $fillable = ['name', 'guard_name'];
}
