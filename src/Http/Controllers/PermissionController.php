<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        return view('locky::permissions.index');
    }
}
