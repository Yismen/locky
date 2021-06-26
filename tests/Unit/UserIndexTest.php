<?php

namespace Dainsys\Locky\Tests\Unit;

use App\User;
use Dainsys\Locky\Http\Livewire\User\UserIndex;
use Dainsys\Locky\Tests\TestCase;
use Illuminate\Support\Facades\App;
use Livewire\Livewire;

class UserIndexTest extends TestCase
{
    /** @test */
    public function it_renders_users_view()
    {
        Livewire::test(UserIndex::class)
            ->assertViewIs('locky::livewire.user.user-index')
            ->assertViewHas('users');
    }

    /** @test */
    public function it_paginates_users()
    {
        $first_user = factory(User::class)->create(['name' => 'Aaaa user']);
        factory(User::class, 10)->create();
        $eleventh = factory(User::class)->create(['name' => 'Zzzz user']);

        Livewire::test(UserIndex::class)
            ->set('amount', 10)
            ->assertSee($first_user->name)
            ->assertDontSee($eleventh->name);
    }

    /** @test */
    public function it_searches_by_name()
    {
        $findable_user = factory(User::class)->create(['name' => 'Aaaa user']);
        $not_findable_user = factory(User::class)->create(['name' => 'Zzzz user']);

        Livewire::test(UserIndex::class)
            ->set('search', $findable_user->name)
            ->assertSee($findable_user->name)
            ->assertDontSee($not_findable_user->name);
    }

    /** @test */
    public function it_searches_by_email()
    {
        $findable_user = factory(User::class)->create(['email' => 'findable@email.com']);
        $not_findable_user = factory(User::class)->create(['email' => 'not_to_Be_found@email.com']);

        Livewire::test(UserIndex::class)
            ->set('search', $findable_user->email)
            ->assertSee($findable_user->email)
            ->assertDontSee($not_findable_user->email);
    }

    /** @test */
    public function it_fires_wants_create_event()
    {
        Livewire::test(UserIndex::class)
            ->call('create')
            ->assertEmitted('wantsCreateUser');
    }

    /** @test */
    public function it_fires_wants_edit_event()
    {
        $user = factory(User::class)->create();

        Livewire::test(UserIndex::class)
            ->call('edit', $user)
            ->assertEmitted('wantsEditUser');
    }

    /** @test */
    public function it_fires_wants_detail_event()
    {
        $user = factory(User::class)->create();

        Livewire::test(UserIndex::class)
            ->call('detail', $user)
            ->assertEmitted('wantsDetailUser');
    }

    /** @test */
    public function it_fires_wants_delete_event()
    {
        $user = factory(User::class)->create();

        Livewire::test(UserIndex::class)
            ->call('delete', $user)
            ->assertEmitted('wantsDeleteUser');
    }
}
