<?php

namespace App\Events;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InviteCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    /*
    OLD GENERATED CODE (commented for safe migration):
    public function __construct()
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
    */

    public function __construct(
        public Invite $invite,
        public ?User $createdBy = null
    ) {
    }
}
