<?php

namespace Dainsys\Locky\Http\Livewire\Role;

use Dainsys\Locky\Models\Role;
use Livewire\Component;

class RoleDetail extends Component
{
    public bool $show = false;

    public Role $role;

    protected $listeners = ['wantsDetailRole' => 'details'];

    public function mount(Role $role = null)
    {
        $this->role = $role->load([
            'users',
            'permissions'
        ]);
    }

    public function render()
    {
        $this->role->load([
            'users',
            'permissions'
        ]);

        return view('locky::livewire.role.role-detail');
    }
    /**
     * Show model details.
     *
     * @param Role $role
     * @return void
     */
    public function details(Role $role)
    {
        $this->role = $role->load([
            'users',
            'permissions'
        ]);

        $this->dispatchBrowserEvent('show-detail-role-modal');
    }
    /**
     * Close all modals
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-detail-role-modal');
    }
}
