<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class SystemActivityNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // OLD GENERATED CODE (commented for safe migration):
    // public function __construct()
    // {
    //     //
    // }
    //
    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }
    //
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }
    //
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public function __construct(
        public string $title,
        public string $message,
        public ?string $actionUrl = null,
        public array $meta = [],
        public ?string $happenedAt = null
    ) {
        $this->happenedAt = $happenedAt ?? now()->toDateTimeString();
    }

    private function formattedTime(): string
    {
        return Carbon::parse($this->happenedAt)->format('d M Y, h:i A');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->message)
            ->line('Date & Time: ' . $this->formattedTime());

        if ($this->actionUrl !== null && $this->actionUrl !== '') {
            $mailMessage->action('Open', $this->actionUrl);
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'system_activity',
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'happened_at' => $this->happenedAt,
            'meta' => $this->meta,
        ];
    }
}
