<?php

namespace Dainsys\Locky\Tests\Feature;

use App\User;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Events\UserCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Dainsys\Locky\Notifications\UserCreatedNotification;
use Dainsys\Locky\Tests\TestCase;

class UserRoutesTest extends TestCase
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_users()
    {
        $user = $this->create(User::class);

        $this->get(route('locky.users.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_users_cant_interact_with_users()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('locky.users.index'))
            ->assertForbidden();
    }

    /** ======================================================================
     * Routes Tests
     * =======================================================================
     */

    /** @test */
    public function user_can_see_users()
    {
        $this->actingAs($this->authorizedUser())->get(route('locky.users.index'))
            ->assertOk()
            ->assertViewIs('locky::users.index');
    }
}
