<?php

namespace Dainsys\Locky;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

trait Lockyable
{
    use HasRoles;
    use SoftDeletes;
}
