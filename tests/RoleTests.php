<?php

namespace Dainsys\Locky\Tests;

use App\User;
use Dainsys\Locky\Permission;
use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Dainsys\Locky\Role;

class RoleTests extends TestCase
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_roles()
    {
        $role = $this->create(Role::class);

        $this->get(route('roles.index'))
            ->assertRedirect(route('login'));

        $this->get(route('roles.show', $role->id))
            ->assertRedirect(route('login'));

        $this->post(route('roles.store', []))
            ->assertRedirect(route('login'));

        $this->get(route('roles.edit', $role->id))
            ->assertRedirect(route('login'));

        $this->patch(route('roles.update', $role->id))
            ->assertRedirect(route('login'));

        $this->delete(route('roles.update', $role->id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_roles_cant_interact_with_roles()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $this->actingAs($user)->get(route('roles.index'))
            ->assertForbidden();

        $this->actingAs($user)->get(route('roles.show', $role->id))
            ->assertForbidden();

        $this->actingAs($user)->post(route('roles.store'))
            ->assertForbidden();

        $this->actingAs($user)->get(route('roles.edit', $role->id))
            ->assertForbidden();

        $this->actingAs($user)->patch(route('roles.update', $role->id))
            ->assertForbidden();

        $this->actingAs($user)->delete(route('roles.destroy', $role->id))
            ->assertForbidden();
    }

    /** ======================================================================
     * Routes Tests
     * =======================================================================
     */

    /** @test */
    public function role_can_see_roles()
    {
        factory(Role::class, 10)->create();
        $this->withoutExceptionHandling();
        $this->actingAs($this->authorizedUser())->get(route('roles.index'))
            ->assertOk()
            ->assertViewIs('locky::roles.index')
            ->assertViewHas('roles', RolesRepository::all());
    }

    /** @test */
    public function role_can_see_a_single_roles()
    {
        $role = factory(Role::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('roles.show', $role->id))
            ->assertViewIs('locky::roles.show')
            ->assertViewHas('role', $role);
    }

    /** @test */
    public function a_role_can_be_stored()
    {
        $attributes = ['name' => 'New Role'];

        $this->actingAs($this->authorizedUser())->post(route('roles.store', $attributes))
            ->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function role_can_be_edited()
    {
        $role = factory(Role::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('roles.edit', $role->id))
            ->assertViewIs('locky::roles.edit')
            ->assertViewHas('role', $role)
            ->assertViewHas('users', UsersRepository::all())
            ->assertViewHas('permissions', PermissionsRepository::all());
    }

    /** @test */
    public function role_can_be_updated()
    {
        $role = factory(Role::class)->create();
        $attributes = ['name' => 'Updated Name'];

        $this->actingAs($this->authorizedUser())->put(route('roles.update', $role->id), $attributes)
            ->assertRedirect(route('roles.edit', $role->id));

        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function users_and_permissions_can_be_synced_on_update()
    {
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create();
        $users = factory(User::class, 3)->create()->pluck('id')->toArray();
        $permissions = factory(Permission::class, 3)->create()->pluck('id')->toArray();

        $attributes = array_merge($role->toArray(), [
            'users' => (array) $users,
            'permissions' => (array) $permissions
        ]);

        $this->actingAs($this->authorizedUser())->put(route('roles.update', $role->id), $attributes);
        $this->assertEquals($users, $role->users()->pluck('id')->toArray());
        $this->assertEquals($permissions, $role->permissions()->pluck('id')->toArray());
    }

    /** @test */
    public function role_can_be_deleted()
    {
        $role = factory(Role::class)->create();

        $this->actingAs($this->authorizedUser())->delete(route('roles.destroy', $role->id))
            ->assertRedirect(route('roles.index'));

        $this->assertDeleted('roles', ['name' => $role->name]);
    }

    /** ===============================================================================
     * Validation Tests
     * ===============================================================================
     */

    /** @test */
    public function a_name_is_required_to_create()
    {
        $this->actingAs($this->authorizedUser())->post(route('roles.store'), ['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_is_required_to_update()
    {
        $role = $this->role();
        $this->actingAs($this->authorizedUser())->put(route('roles.update', $role->id), ['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_be_unique_to_create()
    {
        $role = factory(Role::class)->create();

        $this->actingAs($this->authorizedUser())->post(route('roles.store', ['name' => $role->name]))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_be_unique_to_update()
    {
        $role = $this->role();
        $secondRole = $this->role();
        $this->actingAs($this->authorizedUser())->put(route('roles.update', $role->id), ['name' => $secondRole->name])
            ->assertSessionHasErrors('name');
    }


    /** @test */
    public function name_must_be_unique_except_on_same_role()
    {
        $this->withoutExceptionHandling();
        $role = $this->role();

        $this->actingAs($this->authorizedUser())->put(route('roles.update', $role->id), ['name' => $role->name])
            ->assertSessionDoesntHaveErrors('name');
    }

    protected function role($amount = null)
    {
        return factory(Role::class, $amount)->create();
    }
}