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

    /**
     * Create the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Permission::create($this->validateRequest());

        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('locky::permissions.edit', [
            'permission' => $permission,
            'roles' => RolesRepository::all(),
            'users' => UsersRepository::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Permission $permission)
    {
        $permission->update($this->validateRequest());
        $permission->users()->sync(request('users'));
        $permission->roles()->sync(request('roles'));

        return redirect()->route('permissions.edit', $permission->id);
    }

    protected function validateRequest()
    {
        return $this->validate(request(), [
            'name' => 'required|min:8|unique:permissions,name,' . optional(request()->route('permission'))->id,
            'users' => 'array',
            'roles' => 'array',
        ]);
    }
}
