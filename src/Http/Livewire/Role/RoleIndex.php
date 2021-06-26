<?php

namespace Dainsys\Locky\Http\Livewire\Role;

use Dainsys\Locky\Http\Livewire\PaginationTrait;
use Dainsys\Locky\Models\Role;
use Livewire\Component;

class RoleIndex extends Component
{
    use PaginationTrait;

    public $role;
    /**
     * Event Listeners
     *
     * @var array
     */
    protected $listeners = ['roleSaved' => '$refresh'];
    /**
     * Render the view when variables are updated.
     *
     * @return void
     */
    public function render()
    {
        return view('locky::livewire.role.role-index', [
            'roles' => $this->getPaginatedData(
                $query = Role::query()
                    ->with([
                        'users' => function ($query) {
                            $query->orderBy('name');
                        },
                        'permissions' => function ($query) {
                            $query->orderBy('name');
                        }
                    ]),
                $searchableFields =  [
                    'name',
                    'users.name',
                    'permissions.name',
                ]
            )
        ]);
    }

    public function create()
    {
        $this->emit('wantsCreateRole');
    }

    public function edit(Role $role)
    {
        $this->emit('wantsEditRole', $role);
    }

    public function delete(Role $role)
    {
        $this->emit('wantsDeleteRole', $role);
    }

    public function detail(Role $role)
    {
        $this->emit('wantsDetailRole', $role);
    }
}
