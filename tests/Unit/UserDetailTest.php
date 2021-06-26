<?php

namespace Dainsys\Locky\Tests\Unit;

use App\User;
use Dainsys\Locky\Http\Livewire\User\UserDetail;
use Dainsys\Locky\Tests\TestCase;
use Illuminate\Support\Facades\App;
use Livewire\Livewire;

class UserDetailTest extends TestCase
{
    /** @test */
    public function it_renders_users_view()
    {
        Livewire::test(UserDetail::class)
            ->assertViewIs('locky::livewire.user.user-detail')
            ->assertViewHas('user');
    }

    /** @test */
    public function it_responds_to_wants_detail_event()
    {
        $user = factory(User::class)->create();

        Livewire::test(UserDetail::class)
            ->emit('wantsDetailUser', $user)
            ->assertDispatchedBrowserEvent('show-detail-user-modal')
            ->assertSet('user', $user);
    }
}
