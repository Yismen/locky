<?php

namespace Dainsys\Locky;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

trait WithLockyAcl
{
    use HasRoles;
    use SoftDeletes;

    public function scopeActives($query)
    {
        return $query->whereNull('inactivated_at');
    }

    public function scopeInactives($query)
    {
        return $query->whereNotNull('inactivated_at');
    }

    public function activate()
    {
        $this->inactivated_at = NULL;
        $this->save();
    }

    public function inactivate()
    {
        $this->inactivated_at = now();
        $this->save();
    }
}
