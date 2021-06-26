<?php

namespace Dainsys\Locky\Tests\Feature;

use App\User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Tests\TestCase;

class RoleRoutesTest extends TestCase
{
    /** ===========================================================
     * Authentication and Authorization Tests
     * ============================================================
     */

    /** @test */
    public function guest_are_unauthorized_to_interact_with_roles()
    {
        $role = $this->create(Role::class);

        $this->get(route('locky.roles.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_roles_cant_interact_with_roles()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('locky.roles.index'))
            ->assertForbidden();
    }

    /** ======================================================================
     * Routes Tests
     * =======================================================================
     */

    /** @test */
    public function role_can_see_roles()
    {
        $this->actingAs($this->authorizedUser())->get(route('locky.roles.index'))
            ->assertOk()
            ->assertViewIs('locky::roles.index');
    }

    protected function role($amount = null)
    {
        return factory(Role::class, $amount)->create();
    }
}
