<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;

class CreateUserWalletListener
{

    public function handle(UserCreatedEvent $event)
    {
        $event->user->wallet()->create(['balance' => 0]);
    }
}