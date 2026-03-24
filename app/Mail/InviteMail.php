<?php

namespace App\Mail;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invite $invite)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You Are Invited to Register as a Teacher',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invite',
            with: [
                'invite' => $this->invite,
                'inviteUrl' => route('invite.accept', $this->invite->token),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
