<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Dainsys\Locky\Repositories\RolesRepository;

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
        $roles =  RolesRepository::all();

        return view('locky::roles.index', compact('roles'));
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
            'roles' => Role::orderBy('name')
                ->pluck('name', 'id')
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
            'name' => 'required|unique:roles,name,' . optional(request()->route('role'))->id
        ]);
    }
}
