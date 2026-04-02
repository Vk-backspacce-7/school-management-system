<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChatMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $senderName,
        public string $message,
        public int $senderId
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'chat_message',
            'title' => 'New chat message',
            'message' => "{$this->senderName}: {$this->message}",
            'action_url' => route('principal.dashboard', [], false),
            'happened_at' => now()->toDateTimeString(),
            'meta' => [
                'sender_id' => $this->senderId,
            ],
        ];
    }
}
