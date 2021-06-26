<?php

namespace Dainsys\Locky\Http\Livewire\User;

use Dainsys\Locky\Contracts\UserContract as User;
use Livewire\Component;

class UserDetail extends Component
{
    public bool $show = false;

    public $user;

    protected $listeners = ['wantsDetailUser' => 'details'];

    public function mount($user = null)
    {
        $this->user = $user ?: app(User::class);

        $this->user->load('roles', 'permissions');
    }

    public function render()
    {
        $this->user->load([
            'permissions',
            'roles'
        ]);

        return view('locky::livewire.user.user-detail');
    }
    /**
     * Show model details.
     *
     * @param $user
     * @return void
     */
    public function details($user)
    {
        $this->user = app(User::class)->findOrFail($user);

        $this->dispatchBrowserEvent('show-detail-user-modal');
    }
    /**
     * Close all modals
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-detail-user-modal');
    }
}
