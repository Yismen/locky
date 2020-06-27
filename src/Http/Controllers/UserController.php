<?php

namespace Dainsys\Locky\Http\Controllers;

use App\User;
use Dainsys\Locky\Events\UserCreated;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Authorize all model actions. Additional models should be authorized individually
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  UsersRepository::all();

        return view('locky::users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('locky::users.show', [
            'user' => $user
        ]);
    }

    /**
     * Created a new resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validatedData = $this->validateRequest([
            'password' => 'required|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        event(new UserCreated($user));

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('locky::users.edit', [
            'user' => $user,
            'roles' => RolesRepository::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $validatedData = $this->validateRequest();

        $user->update($validatedData);
        $user->roles()->sync((array) request('roles'));

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore($user)
    {
        if (Gate::denies('delete', User::class)) {
            abort(403, 'Unauthorized');
        }

        $user = User::withTrashed()->find($user)->restore();

        return redirect()->route('users.index');
    }

    protected function validateRequest($additionalRules = [])
    {
        return $this->validate(request(), array_merge([
            'name' => 'required|min:5|unique:users,name,' . optional(request()->route('user'))->id,
            'email' =>  'required|email|unique:users,email,' . optional(request()->route('user'))->id,
            'roles' => 'array'
        ], $additionalRules));
    }
}
