<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Notifications\ChatMessageNotification;

class SendPrincipalChatNotification
{
    public function handle(MessageSent $event): void
    {
        $message = $event->message->loadMissing(['sender:id,name,role', 'receiver:id,name,role']);

        if (! $message->sender || ! $message->receiver) {
            return;
        }

        if (strtolower((string) $message->sender->role) !== 'teacher') {
            return;
        }

        if (strtolower((string) $message->receiver->role) !== 'principal') {
            return;
        }

        $message->receiver->notify(new ChatMessageNotification(
            senderName: $message->sender->name,
            message: $message->message,
            senderId: (int) $message->sender_id
        ));
    }
}
