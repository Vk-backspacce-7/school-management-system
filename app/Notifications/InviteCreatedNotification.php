<?php

namespace App\Notifications;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteCreatedNotification extends Notification
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
        public Invite $invite,
        public ?User $createdBy = null
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail'];
        }

        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $acceptUrl = route('invite.accept', $this->invite->token);

        if ($notifiable instanceof AnonymousNotifiable) {
            return (new MailMessage)
                ->subject('You Are Invited to Register as a Teacher')
                ->greeting('Hello!')
                ->line('You have been invited to register as a Teacher.')
                ->action('Complete Registration', $acceptUrl)
                ->line('This invitation will expire in 7 days.');
        }

        return (new MailMessage)
            ->subject('Invitation Sent Successfully')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Invitation email sent to: ' . $this->invite->email)
            ->action('View Invite Page', route('invite.create'))
            ->line('Invitation expires at: ' . ($this->invite->expires_at?->toDateTimeString() ?? 'N/A'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'invite_created',
            'title' => 'Invitation sent',
            'message' => 'Invitation sent to ' . $this->invite->email,
            'invite_email' => $this->invite->email,
            'invite_token' => $this->invite->token,
            'expires_at' => $this->invite->expires_at?->toDateTimeString(),
            'action_url' => route('invite.create'),
            'created_by_id' => $this->createdBy?->id,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
