<?php

namespace App\Mail;

use App\Models\Pool;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class WeeklyReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  Collection<int, Pool>  $pools
     */
    public function __construct(
        public User $user,
        public string $reminderType,
        public Carbon $nextDraw,
        public string $weekLabel,
        public Collection $pools,
        public bool $hasEntriesThisWeek,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->reminderType === 'final'
            ? 'Last chance — Friday draw is tomorrow!'
            : 'Weekly draw reminder — enter before Friday';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-reminder',
        );
    }
}
