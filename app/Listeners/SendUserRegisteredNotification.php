<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserRegisteredNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    // OLD GENERATED CODE (commented for safe migration):
    // public function __construct()
    // {
    //     //
    // }
    //
    // public function handle(UserRegistered $event): void
    // {
    //     //
    // }

    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(new UserRegisteredNotification());
    }
}
