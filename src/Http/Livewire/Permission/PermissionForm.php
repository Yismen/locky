<?php

namespace Dainsys\Locky\Http\Livewire\Permission;

use Dainsys\Locky\Contracts\UserContract as User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PermissionForm extends Component
{
    protected $listeners = [
        'wantsCreatePermission' => 'create',
        'wantsEditPermission' => 'edit',
        'wantsDeletePermission' => 'delete',
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
        'fields.name' => 'required|min:3',
    ];

    public Permission $permission;

    public $selected_roles = [];

    public function mount(Permission $permission = null)
    {
        $this->permission = $permission->load('roles', 'users');
    }

    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $this->permission->load('roles', 'users');

        $this->selected_roles = $this->permission->roles->pluck('id')->toArray();

        return view('locky::livewire.permission.permission-form', [
            'permission' => $this->permission,
            'roles' => RolesRepository::all(),
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

        Permission::create($this->fields);

        $this->emit('permissionSaved');

        $this->closeForm();
    }
    /**
     * Display the edit form.
     *
     * @param Permission $permission
     * @return void
     */
    public function edit(Permission $permission)
    {
        $this->resetValidation();

        $this->permission = $permission;

        $this->fill(['is_editing' => true, 'fields' => $permission->toArray()]);

        $this->showForm();
    }
    /**
     * Update the current model.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $permission = Permission::findOrFail($this->fields['id']);

        $permission->update($this->fields);

        $this->emit('permissionSaved');

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
    /**
     * Display the delete modal.
     *
     * @param Permission $permission
     * @return void
     */
    public function delete(Permission $permission)
    {
        $this->reset(['fields', 'is_editing']);
        $this->fill(['fields' => $permission->toArray()]);

        $this->dispatchBrowserEvent('show-delete-permission-modal');
    }
    /**
     * Delete current model.
     *
     * @param Permission $permission
     * @return void
     */
    public function completeDelete()
    {
        $permission = Permission::findOrFail($this->fields['id']);

        $this->dispatchBrowserEvent('close-delete-permission-modal');

        $permission->delete();

        $this->emit('permissionSaved');
    }

    public function updateUser($user)
    {
        $user = app(User::class)->find($user);

        Cache::flush();

        if (!$user->hasPermissionTo($this->permission->name)) {
            $user->givePermissionTo($this->permission->name);
        } else {
            $user->revokePermissionTo($this->permission->name);
        };

        $this->emit('permissionSaved');
    }

    public function updateRole(Role $role)
    {
        Cache::flush();

        if (!$role->hasPermissionTo($this->permission->name)) {
            $role->givePermissionTo($this->permission->name);
        } else {
            $role->revokePermissionTo($this->permission->name);
        };

        $this->emit('permissionSaved');
    }

    protected function closeForm()
    {
        $this->dispatchBrowserEvent('close-permission-modal-form');
    }

    protected function showForm()
    {
        $this->dispatchBrowserEvent('show-permission-modal-form');
    }

    public function roleIsSelected($role): bool
    {
        return in_array((int) $role->id, (array) $this->selected_roles);
    }
}
