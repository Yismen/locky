<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Contracts\UserContract as User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;

class LockyViewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions()
    {
        $this->authorize('viewAny', Permission::class);

        return view('locky::permissions.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $this->authorize('viewAny', User::class);

        return view('locky::users.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        $this->authorize('viewAny', Role::class);

        return view('locky::roles.index');
    }
}
