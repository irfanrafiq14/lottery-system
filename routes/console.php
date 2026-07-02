<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('draw:weekly')
    ->weeklyOn(5, '00:00')
    ->timezone(config('app.timezone'))
    ->description('Weekly draw: select winners, soft-delete entries, reset pools, send emails');

Schedule::command('reminders:weekly midweek')
    ->weeklyOn(3, '10:00')
    ->timezone(config('app.timezone'))
    ->description('Midweek reminder for users who have not entered yet');

Schedule::command('reminders:weekly final')
    ->weeklyOn(4, '18:00')
    ->timezone(config('app.timezone'))
    ->description('Final reminder before Friday draw');
