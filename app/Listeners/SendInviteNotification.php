<?php

namespace App\Listeners;

use App\Events\InviteCreated;
use App\Notifications\InviteCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendInviteNotification
{
    // OLD QUEUE STYLE (commented for safe migration):
    // use InteractsWithQueue;
    // class SendInviteNotification implements ShouldQueue

    /**
     * Create the event listener.
     */
    // OLD GENERATED CODE (commented for safe migration):
    // public function __construct()
    // {
    //     //
    // }
    //
    // public function handle(InviteCreated $event): void
    // {
    //     //
    // }

    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(InviteCreated $event): void
    {
        Notification::route('mail', $event->invite->email)
            ->notify(new InviteCreatedNotification($event->invite, $event->createdBy));

        // OLD CODE (commented for safe migration):
        // if ($event->createdBy !== null) {
        //     try {
        //         $event->createdBy->notify(new InviteCreatedNotification($event->invite, $event->createdBy));
        //     } catch (\Throwable $exception) {
        //         report($exception);
        //     }
        // }
    }
}
