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
