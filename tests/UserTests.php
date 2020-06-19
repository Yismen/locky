<?php

namespace Dainsys\Locky\Tests;

use App\User;

class UserTests extends TestCase
{
    /** @test */
    public function user_can_see_users()
    {
        factory(User::class, 10)->create();
        $users = User::orderBy('name')->get();

        $this->actingAs($this->authorizedUser())->get(route('users.index'))
            ->assertOk()
            ->assertViewIs('locky::users.index')
            ->assertViewHas('users', $users);
    }

    // /** @test */
    // public function user_can_see_a_single_users()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($this->user)->get(route('users.show', $user->id))
    //         ->assertOk()
    //         ->assertJson([
    //             'data' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'invoiceable' => $user->invoiceable,
    //             ]
    //         ]);
    // }

    // /** @test */
    // public function a_user_can_be_created()
    // {
    //     $user = factory(User::class)->make()->toArray();

    //     $this->actingAs($this->user)->post(route('users.store'), $user)
    //         ->assertOk()
    //         ->assertJson([
    //             'data' => $user
    //         ]);

    //     $this->assertDatabaseHas('users', ['name' => strtolower($user['name'])]);
    // }

    // /** @test */
    // public function a_user_can_be_updated()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($this->user)->put(route('users.update', $user->id), [
    //         'name' => 'Updated Name'
    //     ])
    //         ->assertOk()
    //         ->assertJson([
    //             'data' => [
    //                 'id' => $user->id,
    //                 'name' => 'Updated Name',
    //                 'invoiceable' => $user->invoiceable,
    //             ]
    //         ]);

    //     $this->assertDatabaseHas('users', [
    //         'name' => 'updated name'
    //     ]);
    // }

    // /** @test */
    // public function name_is_required_to_create_a_user()
    // {
    //     $this->actingAs($this->user)->post(route('users.store'), ['name' => null])
    //         ->assertSessionHasErrors(['name']);
    // }

    // /** @test */
    // public function name_is_required_to_update_a_user()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($this->user)->put(route('users.update', $user->id), ['name' => null])
    //         ->assertSessionHasErrors(['name']);
    // }

    // /** @test */
    // public function name_is_must_be_unique_to_create_a_user()
    // {
    //     factory(User::class)->create(['name' => 'same name']);

    //     $this->actingAs($this->user)->post(route('users.store'), ['name' => 'same name'])
    //         ->assertSessionHasErrors(['name']);
    // }

    // /** @test */
    // public function name_is_must_be_unique_to_update_a_user_except_if_same_id()
    // {
    //     $user = factory(User::class)->create();
    //     $user2 = factory(User::class)->create();

    //     // Try to update user 2 using same name as user 1 should fail validation
    //     $this->actingAs($this->user)->put(route('users.update', $user2->id), ['name' => strtolower($user->name)])
    //         ->assertSessionHasErrors(['name']);

    //     $this->actingAs($this->user)->put(route('users.update', $user->id), ['name' => strtolower($user->name)])
    //         ->assertSessionDoesntHaveErrors(['name']);
    // }
}
