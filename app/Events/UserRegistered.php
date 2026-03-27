<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
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

    public function __construct(public User $user)
    {
    }
}
