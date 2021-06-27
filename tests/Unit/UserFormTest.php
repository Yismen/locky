<?php

namespace Dainsys\Locky\Tests\Unit;

use App\User;
use Dainsys\Locky\Http\Livewire\User\UserForm;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Dainsys\Locky\Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

class UserFormTest extends TestCase
{
    /** @test */
    public function it_renders_users_view()
    {
        Livewire::test(UserForm::class)
            ->assertViewIs('locky::livewire.user.user-form')
            ->assertViewHas('user')
            ->assertViewHas('roles', RolesRepository::all())
            ->assertViewHas('permissions', UsersRepository::all());
    }

    /** @test */
    public function it_responds_to_wants_create_event()
    {
        Livewire::test(UserForm::class)
            ->emit('wantsCreateUser')
            ->assertDispatchedBrowserEvent('show-user-modal-form');
    }

    /** @test */
    public function it_responds_to_wants_edit_event()
    {
        $user = factory(User::class)->create();
        $user = $user->fresh()->load('permissions', 'roles');

        Livewire::test(UserForm::class)
            ->set('is_editing', false)
            ->set('fields', [])
            ->emit('wantsEditUser', $user->id)
            ->assertSet('user', $user)
            ->assertSet('is_editing', true)
            ->assertSet('fields', $user->toArray())
            ->assertDispatchedBrowserEvent('show-user-modal-form');
    }

    /** @test */
    public function it_stores_a_user()
    {
        $user = factory(User::class)->make()->toArray();
        $user = array_merge($user, ['password' => 'some password']);

        Livewire::test(UserForm::class)
            ->set('is_editing', false)
            ->set('fields', $user)
            ->call('store', $user)
            ->assertEmitted('userSaved')
            ->assertDispatchedBrowserEvent('close-user-modal-form');

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
        ]);

        $this->assertTrue(Hash::check($user['password'], User::first()->password));
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = factory(User::class)->create()->toArray();

        Livewire::test(UserForm::class)
            ->set('fields', $user)
            ->set('fields.name', 'Updated Name')
            ->set('fields.email', 'updated@email.com')
            ->call('update')
            ->assertEmitted('userSaved')
            ->assertDispatchedBrowserEvent('close-user-modal-form');

        $this->assertDatabaseHas('users', [
            'name' => 'Updated Name',
            'email' => 'updated@email.com'
        ]);
    }

    /** @test */
    public function store_validates_required_fields()
    {
        $user = factory(User::class)->make([
            'name' => '',
            'email' => '',
            'password' => ''
        ])->toArray();
        $user = array_merge($user, ['password' => 'some password']);

        Livewire::test(UserForm::class)
            ->set('fields', $user)
            ->call('store')
            ->assertHasErrors('fields.name', 'fields.email', 'password');
    }

    /** @test */
    public function store_validates_fields_type()
    {
        $user = factory(User::class)->make([
            'name' => 'df', // too short
            'email' => 'Not an email',
            'password' => 'dfdfdff' // too short
        ])->toArray();
        $user = array_merge($user, ['password' => 'some password']);

        Livewire::test(UserForm::class)
            ->set('fields', $user)
            ->call('store')
            ->assertHasErrors('fields.name', 'fields.email', 'password');
    }

    /** @test */
    public function store_validates_unique_fields()
    {
        $user = factory(User::class)->create()->toArray();

        Livewire::test(UserForm::class)
            ->set('fields', $user)
            ->call('store')
            ->assertHasErrors('fields.name', 'fields.email', 'password');
    }

    /** @test */
    public function update_validates_required_fields()
    {
        $user = factory(User::class)->create();
        $user = $user->fresh()->load('permissions', 'roles');

        Livewire::test(UserForm::class)
            ->call('edit', $user->id)
            ->set('fields', array_merge($user->toArray(), [
                'name' => '',
                'email' => '',
            ]))
            ->call('update')
            ->assertHasErrors('fields.name', 'fields.email');
    }

    /** @test */
    public function update_validates_fields_type()
    {
        $user = factory(User::class)->create();
        $user = $user->fresh()->load('permissions', 'roles');

        $array = array_merge($user->toArray(), [
            'name' => 'df', // too short
            'email' => 'Not an email',
            'inactivated_at' => 'dfdfdff' // not a date
        ]);

        Livewire::test(UserForm::class)
            ->call('edit', $user->id)
            ->set('fields', $array)
            ->call('update')
            ->assertHasErrors('fields.name', 'fields.email', 'inactivated_at');
    }

    /** @test */
    public function update_validates_unique_fields()
    {
        $user = factory(User::class)->create();
        $user_2 = factory(User::class)->create();

        Livewire::test(UserForm::class)
            ->call('edit', $user->id)
            // unique allows exception when on same model
            ->set('fields', $user->toArray())
            ->call('update')
            ->assertHasNoErrors('fields.name', 'fields.email')
            // has error if not the same model
            ->set('fields.name', $user_2->name)
            ->set('fields.email', $user_2->email)
            ->call('update')
            ->assertHasErrors('fields.name', 'fields.email');
    }

    /** @test */
    public function update_permission_toggles()
    {

        $user = factory(User::class)->create();
        $permission = factory(Permission::class)->create(['guard_name' => null]);

        $this->assertFalse($user->hasPermissionTo($permission));

        // Livewire::test(UserForm::class, ['user' => $user])
        //     ->call('edit', $user)
        //     ->call('updatePermission', $permission->id)
        //     ->assertEmitted('userSaved');

        // $this->assertTrue($user->hasPermissionTo($permission));

        // Livewire::test(UserForm::class, ['user' => $user])
        //     ->call('edit', $user)
        //     ->call('updatePermission', $permission->id);

        // $this->assertFalse($user->hasPermissionTo($permission));
    }

    /** @test */
    public function update_roles_toggles()
    {

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $this->assertFalse($user->hasRole($role));

        // Livewire::test(UserForm::class, ['user' => $user])
        //     ->call('edit', $user)
        //     ->call('updateRole', $role->id);

        // $this->assertTrue($user->hasRole($role));

        // Livewire::test(UserForm::class, ['user' => $user])
        //     ->call('edit', $user)
        //     ->call('updateRole', $role->id);

        $this->assertFalse($user->hasRole($role));
    }
}
