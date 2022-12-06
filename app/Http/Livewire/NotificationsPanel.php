<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsPanel extends Component
{
    public $notifications;

    protected $listeners = [
        'NotificationAdded' => 'updatePanel',
    ];

    public function mount(): void
    {
        $this->fetchNotifications();
    }

    public function render()
    {
        return view('livewire.notifications-panel');
    }

    public function updatePanel()
    {
        dd('s');
        $this->fetchNotifications();
    }

    public function fetchNotifications()
    {
        $this->notifications = Notification::join('notification_user', 'notification_user.notification_id', '=', 'notifications.id')
            ->where('notification_user.user_id', '=', Auth::user()->id)
            ->get(['notifications.*']);
    }
}
