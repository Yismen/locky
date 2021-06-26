<?php

namespace Dainsys\Locky\Tests\Feature;

use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use App\User;
use Dainsys\Locky\Tests\TestCase;

class PermissionRoutesTest extends TestCase
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_permissions()
    {
        $this->get(route('locky.permissions.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_permissions_cant_interact_with_permissions()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('locky.permissions.index'))
            ->assertForbidden();
    }

    /** @test */
    public function permission_can_see_permissions()
    {
        $this->actingAs($this->authorizedUser())->get(route('locky.permissions.index'))
            ->assertOk()
            ->assertViewIs('locky::permissions.index');
    }

    protected function permission($amount = null)
    {
        return factory(Permission::class, $amount)->create();
    }
}
