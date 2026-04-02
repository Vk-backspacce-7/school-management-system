<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $connection = 'sync';

    public bool $afterCommit = true;

    public function __construct(public Message $message)
    {
        $this->message->loadMissing(['sender:id,name,role', 'receiver:id,name,role']);
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('chat.' . $this->message->receiver_id)];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'is_seen' => (bool) $this->message->is_seen,
            'created_at' => $this->message->created_at?->toISOString(),
            'created_at_readable' => $this->message->created_at?->format('h:i A'),
            'sender_name' => $this->message->sender?->name,
            'sender_role' => strtolower((string) $this->message->sender?->role),
        ];
    }
}
