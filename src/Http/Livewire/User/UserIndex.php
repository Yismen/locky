<?php

namespace Dainsys\Locky\Http\Livewire\User;

use Dainsys\Locky\Http\Livewire\PaginationTrait;
use Dainsys\Locky\Contracts\UserContract as User;
use Livewire\Component;

class UserIndex extends Component
{
    use PaginationTrait;

    /**
     * Event Listeners
     *
     * @var array
     */
    protected $listeners = ['userSaved' => '$refresh'];
    /**
     * Render the view when variables are updated.
     *
     * @return void
     */
    public function render()
    {
        return view('locky::livewire.user.user-index', [
            'users' => $this->getPaginatedData(
                $query = app(User::class)->query()
                    ->with([
                        'roles' => function ($query) {
                            $query->orderBy('name');
                        },
                        // 'permissions' => function ($query) {
                        //     $query->orderBy('name');
                        // },
                    ]),
                $searchableFields =  [
                    'name',
                    'email',
                    'roles.name',
                    // 'permissions.name',
                ]
            )
        ]);
    }

    public function create()
    {
        $this->emit('wantsCreateUser');
    }

    public function edit($user)
    {
        $this->emit('wantsEditUser', $user);
    }

    public function delete($user)
    {
        $this->emit('wantsDeleteUser', $user);
    }

    public function detail($user)
    {
        $this->emit('wantsDetailUser', $user);
    }
}
