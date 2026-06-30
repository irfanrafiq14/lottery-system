<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    return (int) $user->id === $userId;
});

Broadcast::channel('admin.dashboard', function ($user) {
    return $user instanceof Admin;
});
