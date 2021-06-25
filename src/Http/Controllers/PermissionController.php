<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;

class PermissionController extends Controller
{
    /**
     * Authorize all model actions. Additional models should be authorized individually
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions =  PermissionsRepository::all();

        return view('locky::permissions.index', compact('permissions'));
    }
}
