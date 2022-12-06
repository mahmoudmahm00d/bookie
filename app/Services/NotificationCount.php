<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationCount 
{
    public static function get()
    {
        return Notification::join('notification_user', 'notification_user.notification_id', '=', 'notifications.id', 'left')
            ->where('notification_user.user_id', '=', Auth::user()->id)
            ->orWhere('notifications.public', '=', 1)
            ->distinct()
            ->count();
    }
}
