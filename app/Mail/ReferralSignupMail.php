<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralSignupMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $referrer,
        public User $newUser,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Someone joined using your referral link!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.referral-signup',
        );
    }
}
