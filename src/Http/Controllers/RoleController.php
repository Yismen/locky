<?php

namespace Dainsys\Locky\Http\Controllers;

use Dainsys\Locky\Models\Role as ModelsRole;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', ModelsRole::class);

        return view('locky::roles.index');
    }
}
