<?php

namespace Dainsys\Locky\Http\Livewire\User;

use App\User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Repositories\RolesRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    protected $listeners = [
        'wantsCreateUser' => 'create',
        'wantsEditUser' => 'edit',
        'wantsDeleteUser' => 'delete',
    ];
    /**
     * Control is editing status
     */
    public bool $is_editing = false;
    /**
     * Array of fields to serve as model
     */
    public array $fields = [
        'name',
        'email',
        'password',
        'inactivated_at',
    ];
    /**
     * Validation Rules
     */
    protected array $rules = [
        'fields.name' => 'required|min:3|unique:users,name',
        'fields.email' => 'required|min:3|unique:users,email',
        'fields.password' => 'nullable|min:8',
        'fields.inactivated_at' => 'sometimes|nullable|date',
    ];

    public User $user;

    public $selected_roles = [];

    public function mount(User $user = null)
    {
        $this->user = $user->load('permissions', 'roles');
    }

    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $this->selected_roles = $this->user->roles->pluck('id')->toArray();

        return view('locky::livewire.user.user-form', [
            'user' => $this->user,
            'roles' => RolesRepository::all(),
            'permissions' => PermissionsRepository::all(),
        ]);
    }
    /**
     * Display the create form.
     *
     * @return void
     */
    public function create()
    {
        $this->resetValidation();
        $this->reset(['fields', 'is_editing']);

        $this->showForm();
    }
    /**
     * Store the new model.
     *
     * @return void
     */
    public function store()
    {
        $this->validate(array_merge(
            $this->rules,
            [
                'fields.password' => 'required|min:8'
            ]
        ));

        $this->fields['password'] = Hash::make($this->fields['password']);

        User::create($this->fields);

        $this->emit('userSaved');

        $this->closeForm();
    }
    /**
     * Display the edit form.
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $this->resetValidation();

        $this->user = $user->load('permissions', 'roles');

        $this->fill(['is_editing' => true, 'fields' => $user->toArray()]);

        $this->showForm();
    }
    /**
     * Update the current model.
     *
     * @return void
     */
    public function update()
    {
        $this->validate(array_merge(
            $this->rules,
            [
                'fields.name' => 'required|min:3|unique:users,name,' . $this->fields['id'],
                'fields.email' => 'required|min:3|unique:users,email,' . $this->fields['id'],
            ]
        ));

        $user = User::findOrFail($this->fields['id']);

        $user->update($this->fields);

        $this->emit('userSaved');

        $this->closeForm();
    }
    /**
     * Reset validation when variables are updated
     *
     * @param string $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatePermission(Permission $permission)
    {
        Cache::flush();

        if (!$this->user->hasPermissionTo($permission->name)) {
            $this->user->givePermissionTo($permission->name);
        } else {
            $this->user->revokePermissionTo($permission->name);
        };

        $this->emit('userSaved');
    }

    public function updateRole(Role $role)
    {
        Cache::flush();

        if (!$this->user->hasRole($role->name)) {
            $this->user->assignRole($role->name);
        } else {
            $this->user->removeRole($role->name);
        };

        $this->emit('userSaved');
    }

    protected function closeForm()
    {
        $this->dispatchBrowserEvent('close-user-modal-form');
    }

    protected function showForm()
    {
        $this->dispatchBrowserEvent('show-user-modal-form');
    }
}
