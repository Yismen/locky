<?php

namespace Dainsys\Locky\Http\Livewire\Permission;

use Dainsys\Locky\Models\Permission;
use Livewire\Component;

class PermissionDetail extends Component
{
    public bool $show = false;

    public Permission $permission;

    protected $listeners = ['wantsDetailPermission' => 'details'];

    public function mount(Permission $permission = null)
    {
        $this->permission = $permission->load([
            'users',
            'roles'
        ]);
    }

    public function render()
    {
        $this->permission->load([
            'users',
            'roles'
        ]);
        return view('locky::livewire.permission.permission-detail');
    }
    /**
     * Show model details.
     *
     * @param Permission $permission
     * @return void
     */
    public function details(Permission $permission)
    {
        $this->permission = $permission;

        $this->dispatchBrowserEvent('show-detail-permission-modal');
    }
    /**
     * Close all modals
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-detail-permission-modal');
    }
}
