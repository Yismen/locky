<?php

namespace Dainsys\Locky\Tests;

use App\User;

class UserAuthorizationTests extends TestCase
{
    /** @test */
    public function guest_are_unauthorized_to_interact_with_users()
    {
        $user = $this->create(User::class);

        $this->get(route('users.index'))
            ->assertRedirect(route('login'));

        $this->get(route('users.show', $user->id))
            ->assertRedirect(route('login'));

        $this->get(route('users.create'))
            ->assertRedirect(route('login'));

        $this->post(route('users.store', []))
            ->assertRedirect(route('login'));

        $this->get(route('users.edit', $user->id))
            ->assertRedirect(route('login'));

        $this->patch(route('users.update', $user->id))
            ->assertRedirect(route('login'));

        $this->delete(route('users.update', $user->id))
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

        $this->actingAs($user)->get(route('users.create'))
            ->assertForbidden();

        $this->actingAs($user)->post(route('users.store', []))
            ->assertForbidden();

        $this->actingAs($user)->get(route('users.edit', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->patch(route('users.update', $user->id))
            ->assertForbidden();

        $this->actingAs($user)->delete(route('users.update', $user->id))
            ->assertForbidden();
    }
}
