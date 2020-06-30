<?php

namespace Dainsys\Locky;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

trait WithLockyAcl
{
    use HasRoles;
    use SoftDeletes;
}
