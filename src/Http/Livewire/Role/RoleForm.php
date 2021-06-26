<?php

namespace Dainsys\Locky\Http\Livewire\Role;

use App\User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RoleForm extends Component
{
    protected $listeners = [
        'wantsCreateRole' => 'create',
        'wantsEditRole' => 'edit',
        'wantsDeleteRole' => 'delete',
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
    ];
    /**
     * Validation Rules
     */
    protected array $rules = [
        'fields.name' => 'required|min:3|unique:roles,name',
    ];

    public Role $role;

    public $selected_users = [];

    public function mount(Role $role = null)
    {
        $this->role = $role->load('permissions', 'users');
    }

    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $this->role->load('permissions', 'users');

        $this->selected_users = $this->role->users->pluck('id')->toArray();

        return view('locky::livewire.role.role-form', [
            'permissions' => PermissionsRepository::all(),
            'users' => UsersRepository::all(),
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
        $this->validate();

        Role::create($this->fields);

        $this->emit('roleSaved');

        $this->closeForm();
    }
    /**
     * Display the edit form.
     *
     * @param Role $role
     * @return void
     */
    public function edit(Role $role)
    {
        $this->resetValidation();

        $this->role = $role;

        $this->fill(['is_editing' => true, 'fields' => $role->toArray()]);

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
                'fields.name' => 'required|min:3|unique:roles,name,' . $this->fields['id'],
            ]
        ));

        $role = Role::findOrFail($this->fields['id']);

        $role->update($this->fields);

        $this->emit('roleSaved');

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
    public function updateUser(User $user)
    {
        Cache::flush();

        if (!$user->hasRole($this->role->name)) {
            $user->assignRole($this->role->name);
        } else {
            $user->removeRole($this->role->name);
        };

        $this->emit('roleSaved');
    }

    public function updatePermission(Permission $permission)
    {
        Cache::flush();

        if (!$this->role->hasPermissionTo($permission->name)) {
            $this->role->givePermissionTo($permission->name);
        } else {
            $this->role->revokePermissionTo($permission->name);
        };

        $this->emit('roleSaved');
    }

    protected function closeForm()
    {
        $this->dispatchBrowserEvent('close-role-modal-form');
    }

    protected function showForm()
    {
        $this->dispatchBrowserEvent('show-role-modal-form');
    }

    public function roleIsSelected($role): bool
    {
        return in_array((int) $role->id, (array) $this->selected_users);
    }
}
