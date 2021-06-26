<?php

namespace Dainsys\Locky\Events;

use Dainsys\Locky\Notifications\UserCreatedNotification;
use Dainsys\Locky\Contracts\UserContract as User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->token = Str::random(60);

        $this->updateOrInsertUser()
            ->notifyUser();
    }

    protected function updateOrInsertUser()
    {
        DB::table('password_resets')->updateOrInsert(
            ['email' => $this->user->email],
            [
                'token' => Hash::make($this->token),
                'created_at' => now()
            ]
        );

        return $this;
    }

    protected function notifyUser()
    {
        $this->user->notify(new UserCreatedNotification($this->token));

        return $this;
    }
}
