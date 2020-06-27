<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Role;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;

class RoleController extends Controller
{
    /**
     * Authorize all model actions. Additional models should be authorized individually
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = RolesRepository::all();

        return view('locky::roles.index', [
            'roles' => RolesRepository::all(),
        ]);
    }

    /**
     * Create the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Role::create($this->validateRequest());

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('locky::roles.show', [
            'role' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('locky::roles.edit', [
            'role' => $role,
            'users' => UsersRepository::all(),
            'permissions' => PermissionsRepository::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role)
    {
        $role->update($this->validateRequest());
        $role->users()->sync(request('users'));
        $role->permissions()->sync(request('permissions'));

        return redirect()->route('roles.edit', $role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index');
    }

    protected function validateRequest()
    {
        return $this->validate(request(), [
            'name' => 'required|unique:roles,name,' . optional(request()->route('role'))->id,
            'users' => 'array',
            'permissions' => 'array',
        ]);
    }
}
