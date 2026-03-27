<?php

namespace App\Providers;

use App\Events\InviteCreated;
use App\Events\UserRegistered;
use App\Listeners\SendInviteNotification;
use App\Listeners\SendUserRegisteredNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendUserRegisteredNotification::class,
        ],
        InviteCreated::class => [
            SendInviteNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    // OLD GENERATED CODE (commented for safe migration):
    // public function register(): void
    // {
    //     //
    // }
    //
    // public function boot(): void
    // {
    //     //
    // }

    public function boot(): void
    {
        parent::boot();
    }
}
