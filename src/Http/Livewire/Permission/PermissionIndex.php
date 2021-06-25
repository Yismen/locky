<?php

namespace Dainsys\Locky\Http\Livewire\Permission;

use Dainsys\Locky\Http\Livewire\PaginationTrait;
use Dainsys\Locky\Models\Permission;
use Livewire\Component;

class PermissionIndex extends Component
{
    use PaginationTrait;

    public $permission;
    /**
     * Event Listeners
     *
     * @var array
     */
    protected $listeners = ['permissionSaved' => '$refresh'];
    /**
     * Render the view when variables are updated.
     *
     * @return void
     */
    public function render()
    {
        return view('locky::livewire.permission.permission-index', [
            'permissions' => $this->getPaginatedData(
                $query = Permission::query()
                    ->with([
                        'users' => function ($query) {
                            $query->orderBy('name');
                        },
                        'roles' => function ($query) {
                            $query->orderBy('name');
                        }
                    ]),
                $searchableFields =  [
                    'name',
                    'users.name',
                    'roles.name',
                ]
            )
        ]);
    }

    public function create()
    {
        $this->emit('wantsCreatePermission');
    }

    public function edit(Permission $permission)
    {
        $this->emit('wantsEditPermission', $permission);
    }

    public function delete(Permission $permission)
    {
        $this->emit('wantsDeletePermission', $permission);
    }

    public function detail(Permission $permission)
    {
        $this->emit('wantsDetailPermission', $permission);
    }
}
