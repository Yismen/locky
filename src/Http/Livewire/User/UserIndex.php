<?php

namespace Dainsys\Locky\Http\Livewire\User;

use Dainsys\Locky\Http\Livewire\PaginationTrait;
use App\User;
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
                $query = User::query()
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

    public function edit(User $user)
    {
        $this->emit('wantsEditUser', $user);
    }

    public function delete(User $user)
    {
        $this->emit('wantsDeleteUser', $user);
    }

    public function detail(User $user)
    {
        $this->emit('wantsDetailUser', $user);
    }
}
