<?php

namespace Dainsys\Locky\Tests;

use App\User;
use Dainsys\Locky\Repositories\UsersRepository;
use Dainsys\Locky\Role;

class UserTests extends TestCase
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_users()
    {
        $user = $this->create(User::class);

        $this->get(route('users.index'))
            ->assertRedirect(route('login'));

        $this->get(route('users.show', $user->id))
            ->assertRedirect(route('login'));

        $this->post(route('users.store', []))
            ->assertRedirect(route('login'));

        $this->get(route('users.edit', $user->id))
            ->assertRedirect(route('login'));

        $this->patch(route('users.update', $user->id))
            ->assertRedirect(route('login'));

        $this->delete(route('users.update', $user->id))
            ->assertRedirect(route('login'));

        $this->post(route('users.restore', $user->id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_users_cant_interact_with_users()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('users.index'))
            ->assertForbidden();

        $this->actingAs($user)->get(route('users.show', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->get(route('users.edit', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->patch(route('users.update', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->delete(route('users.update', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->post(route('users.restore', $user->id))
            ->assertForbidden();
    }

    /** ======================================================================
     * Routes Tests
     * =======================================================================
     */

    /** @test */
    public function user_can_see_users()
    {
        factory(User::class, 10)->create();

        $this->actingAs($this->authorizedUser())->get(route('users.index'))
            ->assertOk()
            ->assertViewIs('locky::users.index')
            ->assertViewHas('users', UsersRepository::all());
    }

    /** @test */
    public function user_can_see_a_single_users()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('users.show', $user->id))
            ->assertViewIs('locky::users.show')
            ->assertViewHas('user', $user);
    }

    /** @test */
    public function user_can_be_edited()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())->get(route('users.edit', $user->id))
            ->assertViewIs('locky::users.edit')
            ->assertViewHas('user', $user)
            ->assertViewHas('roles', Role::orderBy('name')->pluck('name', 'id'));
    }

    /** @test */
    public function user_can_be_updated()
    {
        $user = factory(User::class)->create();
        $attributes = ['name' => 'Updated Name', 'email' => 'updated@email.com'];

        $this->actingAs($this->authorizedUser())->put(route('users.update', $user->id), $attributes)
            ->assertRedirect(route('users.edit', $user->id));

        $this->assertDatabaseHas('users', $attributes);
    }

    /** @test */
    public function user_can_be_deleted()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())->delete(route('users.destroy', $user->id))
            ->assertRedirect(route('users.index'));

        $this->assertSoftDeleted('users', ['name' => $user->name, 'email' => $user->email]);
    }

    /** @test */
    public function user_can_be_restored()
    {
        $user = factory(User::class)->create();
        $user->delete();
        $user = User::withTrashed()->find($user->id);

        $this->actingAs($this->authorizedUser())->post(route('users.restore', $user->id))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', ['name' => $user->name, 'email' => $user->email, 'deleted_at' => null]);
    }
    /** ===============================================================================
     * Validation Tests
     * ===============================================================================
     */

    /** @test */
    public function name_and_email_is_required_to_update()
    {
        $attributes = ['name' => null, 'email' => null];
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())
            ->put(route('users.update', $user->id), $attributes)
            ->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function name_and_email_should_be_minimum_5_characters()
    {
        $attributes = ['name' => '51', 'a@a.'];
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())
            ->put(route('users.update', $user->id), $attributes)
            ->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function name_and_email_must_be_unique()
    {
        $user = factory(User::class)->create();
        $secondUser = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())
            ->put(route('users.update', $user->id), ['name' => $secondUser->name, 'email' => $secondUser->email])
            ->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function name_and_email_must_be_unique_except_for_same_update()
    {
        $sameName = ['name' => 'Repeated Name', 'email' => 'repeated@email.com'];
        $user = factory(User::class)->create($sameName);

        $this->actingAs($this->authorizedUser())
            ->put(route('users.update', $user->id), $sameName)
            ->assertSessionDoesntHaveErrors(['name', 'email']);
    }

    /** @test */
    public function email_must_be_of_type_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->authorizedUser())
            ->put(route('users.update', $user->id), ['email' => 'not a valid email'])
            ->assertSessionHasErrors('email');
    }
}
