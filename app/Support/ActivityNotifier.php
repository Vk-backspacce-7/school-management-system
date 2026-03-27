<?php

namespace App\Support;

use App\Models\User;
use App\Notifications\SystemActivityNotification;

class ActivityNotifier
{
    public static function send(
        ?User $user,
        string $title,
        string $message,
        ?string $actionUrl = null,
        array $meta = []
    ): void {
        if ($user === null) {
            return;
        }

        try {
            $user->notify(new SystemActivityNotification(
                title: $title,
                message: $message,
                actionUrl: $actionUrl,
                meta: $meta
            ));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
