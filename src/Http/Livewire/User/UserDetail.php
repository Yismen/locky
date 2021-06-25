<?php

namespace Dainsys\Locky\Http\Livewire\User;

use App\User;
use Livewire\Component;

class UserDetail extends Component
{
    public bool $show = false;

    public User $user;

    protected $listeners = ['wantsDetailUser' => 'details'];

    public function mount(User $user = null)
    {
        $this->user = $user;
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
     * @param User $user
     * @return void
     */
    public function details(User $user)
    {
        $this->user = $user;

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
