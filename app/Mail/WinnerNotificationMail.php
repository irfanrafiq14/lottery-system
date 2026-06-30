<?php

namespace App\Mail;

use App\Models\Pool;
use App\Models\User;
use App\Support\WeekHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WinnerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Pool $pool,
        public int $weekNumber,
        public int $winnerPrize,
        public int $totalPool,
        public int $participants,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Congratulations! You Won the '.$this->pool->name.' Pool Draw',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.winner',
            with: [
                'weekLabel' => WeekHelper::formatWeekNumber($this->weekNumber),
            ],
        );
    }
}
