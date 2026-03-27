<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegisteredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
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
        // Use route('login') if exists, else fallback to a URL
        $loginUrl = route('login', [], false); // make sure route('login') exists

        return (new MailMessage)
            ->subject('Welcome to Our Platform!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for registering on our website.')
            ->action('Visit Dashboard', $loginUrl)
            ->line('We are glad to have you!');
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toArray(object $notifiable): array
    {
        // Safe route usage
        $loginUrl = route('login', [], false); // make sure you have a named route 'login'

        return [
            'type' => 'user_registered',
            'title' => 'Registration successful',
            'message' => 'Welcome! Your account was created successfully.',
            'action_url' => $loginUrl,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}