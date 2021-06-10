<?php

namespace Dainsys\Locky\Tests\Unit;

use App\User;
use Dainsys\Locky\Tests\TestCase as TestsTestCase;

class UserTest extends TestsTestCase
{
    /** @test */
    public function it_filter_active_users()
    {
        $this->create(User::class, 3, ['inactivated_at' => null]);
        $this->create(User::class, 2, ['inactivated_at' => now()]);

        $actives = User::actives()->get();

        $this->assertCount(3, $actives);
    }

    /** @test */
    public function it_filter_inactive_users()
    {
        $this->create(User::class, 2, ['inactivated_at' => null]);
        $this->create(User::class, 3, ['inactivated_at' => now()]);

        $actives = User::inactives()->get();

        $this->assertCount(3, $actives);
    }

    /** @test */
    public function inactive_users_can_be_activated()
    {
        $this->create(User::class, 3, ['inactivated_at' => now()]);
        $user = User::inactives()->first();

        $user->activate();

        $this->assertNull($user->inactivated_at);
    }

    /** @test */
    public function active_users_can_be_inactivated()
    {
        $this->create(User::class, 3, ['inactivated_at' => NULL]);
        $user = User::actives()->first();

        $user->inactivate();

        $this->assertNotNull($user->inactivated_at);
    }
}
