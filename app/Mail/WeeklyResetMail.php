<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class WeeklyResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  Collection<int, \App\Models\Winner>  $lastWeekWinners
     */
    public function __construct(
        public User $user,
        public Collection $lastWeekWinners,
        public string $weekLabel,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Weekly Draw Started - Join Now',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-reset',
        );
    }
}
