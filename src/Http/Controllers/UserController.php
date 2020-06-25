<?php

namespace Dainsys\Locky\Http\Controllers;

use App\User;
use Dainsys\Locky\Repositories\UsersRepository;
use Dainsys\Locky\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('locky::users.edit', [
            'user' => $user,
            'roles' => Role::orderBy('name')
                ->pluck('name', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|min:5|unique:users,name,' . $user->id,
            'email' =>  'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validatedData);

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
}
