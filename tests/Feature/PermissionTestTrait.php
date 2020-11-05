<?php

namespace Dainsys\Locky\Tests\Feature;

use Dainsys\Locky\Permission;
use Dainsys\Locky\Repositories\PermissionsRepository;
use Dainsys\Locky\Repositories\RolesRepository;
use Dainsys\Locky\Repositories\UsersRepository;
use Dainsys\Locky\Role;
use Dainsys\Locky\Tests\TestCase;
use App\User;

trait PermissionTestTrait
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_permissions()
    {
        $permission = $this->create(Permission::class);

        $this->get(route('permissions.index'))
            ->assertRedirect(route('login'));

        $this->get(route('permissions.show', $permission->id))
            ->assertRedirect(route('login'));

        $this->post(route('permissions.store', []))
            ->assertRedirect(route('login'));

        $this->get(route('permissions.edit', $permission->id))
            ->assertRedirect(route('login'));

        $this->patch(route('permissions.update', $permission->id))
            ->assertRedirect(route('login'));

        $this->delete(route('permissions.update', $permission->id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_permissions_cant_interact_with_permissions()
    {
        $user = factory(User::class)->create();
        $permission = factory(Permission::class)->create();

        $this->actingAs($user)->get(route('permissions.index'))
            ->assertForbidden();

        $this->actingAs($user)->get(route('permissions.show', $permission->id))
            ->assertForbidden();

        $this->actingAs($user)->post(route('permissions.store'))
            ->assertForbidden();

        $this->actingAs($user)->get(route('permissions.edit', $permission->id))
            ->assertForbidden();

        $this->actingAs($user)->patch(route('permissions.update', $permission->id))
            ->assertForbidden();

        $this->actingAs($user)->delete(route('permissions.destroy', $permission->id))
            ->assertForbidden();
    }

    /** @test */
    public function permission_can_see_permissions()
    {
        factory(Permission::class, 2)->create();

        $this->actingAs($this->authorizedUser())->get(route('permissions.index'))
            ->assertOk()
            ->assertViewIs('locky::permissions.index')
            ->assertViewHas('permissions', Permission::orderBy('name')->with('roles', 'users')->get());
    }

    /** @test */
    public function permission_can_see_a_single_permissions()
    {
        $permission = factory(Permission::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('permissions.show', $permission->id))
            ->assertViewIs('locky::permissions.show')
            ->assertViewHas('permission', $permission);
    }

    /** @test */
    public function a_permission_can_be_stored()
    {
        $attributes = ['name' => 'New Permission'];

        $this->actingAs($this->authorizedUser())->post(route('permissions.store', $attributes))
            ->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', $attributes);
    }

    /** @test */
    public function permission_can_be_edited()
    {
        $this->withoutExceptionHandling();
        $permission = factory(Permission::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('permissions.edit', $permission->id))
            ->assertViewIs('locky::permissions.edit')
            ->assertViewHas('permission', $permission)
            ->assertViewHas('roles', RolesRepository::all())
            // ->assertViewHas('users', UsersRepository::all())
        ;
    }

    /** @test */
    public function permission_can_be_updated()
    {
        $permission = factory(Permission::class)->create();
        $attributes = ['name' => 'Updated Name'];

        $this->actingAs($this->authorizedUser())->put(route('permissions.update', $permission->id), $attributes)
            ->assertRedirect(route('permissions.edit', $permission->id));

        $this->assertDatabaseHas('permissions', $attributes);
    }

    /** @test */
    public function users_and_permissions_can_be_synced_on_update()
    {
        $permission = factory(Permission::class)->create();
        $users = factory(User::class, 3)->create()->pluck('id')->toArray();
        $roles = factory(Role::class, 3)->create()->pluck('id')->toArray();

        $attributes = array_merge($permission->toArray(), [
            'users' => (array) $users,
            'roles' => (array) $roles
        ]);

        $this->actingAs($this->authorizedUser())->put(route('permissions.update', $permission->id), $attributes);
        $this->assertEquals($users, $permission->users()->pluck('id')->toArray());
        $this->assertEquals($roles, $permission->roles()->pluck('id')->toArray());
    }

    /** @test */
    public function permission_can_be_deleted()
    {
        $permission = factory(Permission::class)->create();

        $this->actingAs($this->authorizedUser())->delete(route('permissions.destroy', $permission->id))
            ->assertRedirect(route('permissions.index'));

        $this->assertDeleted('permissions', ['name' => $permission->name]);
    }

    /** ===============================================================================
     * Validation Tests
     * ===============================================================================
     */

    /** @test */
    public function a_name_is_required_to_create()
    {
        $this->actingAs($this->authorizedUser())->post(route('permissions.store'), ['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_is_required_to_update()
    {
        $permission = $this->permission();
        $this->actingAs($this->authorizedUser())->put(route('permissions.update', $permission->id), ['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_be_unique_to_create()
    {
        $permission = factory(Permission::class)->create();

        $this->actingAs($this->authorizedUser())->post(route('permissions.store', ['name' => $permission->name]))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_be_unique_to_update()
    {
        $permission = $this->permission();
        $secondPermission = $this->permission();
        $this->actingAs($this->authorizedUser())->put(route('permissions.update', $permission->id), ['name' => $secondPermission->name])
            ->assertSessionHasErrors('name');
    }


    /** @test */
    public function name_must_be_unique_except_on_same_permission()
    {
        $this->withoutExceptionHandling();
        $permission = $this->permission();

        $this->actingAs($this->authorizedUser())->put(route('permissions.update', $permission->id), ['name' => $permission->name])
            ->assertSessionDoesntHaveErrors('name');
    }

    protected function permission($amount = null)
    {
        return factory(Permission::class, $amount)->create();
    }
}
