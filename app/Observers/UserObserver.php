<?php

namespace App\Observers;

use App\Models\User;
use App\Events\UserCreatedEvent;

class UserObserver
{
    public function created(User $user)
    {
        UserCreatedEvent::dispatch($user);
    }
}