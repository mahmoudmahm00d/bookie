<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Livewire\Component;

class CreateNotification extends Component
{
    public $notification;
    public $usersList;
    public $users;

    protected $rules = [
        'post.title' => 'required|string|max:255',
        'post.body' => 'required|string|max:255',
        'post.public' => 'nullable',
    ];
    
    public function mount()
    {
        $this->emit('NotificationAdded');
        $this->usersList = User::where('id', '<>', 1)->get();
    }
    
    public function addNotification()
    {
        $this->emit('NotificationAdded');
        $this->notification['public'] = ($this->notification['public'] == null) ? false : true;

        $notification = Notification::create($this->notification);

        if (!$this->notification['public'] && $this->users) {
            foreach ($this->users as $userId) {
                try {
                    UserNotification::create([
                        'notification_id' => $notification->id,
                        'user_id' => $userId
                    ]);
                } catch (\Throwable $th) {
                    dd($th);
                    return redirect('/notifications')->with('message', 'Book Created With Genres Errors!');
                }
            }
        }

        $this->emit('NotificationAdded');
        return redirect('/notifications')->with('Notification Created Successfully!');
    }

    public function render()
    {
        return view('livewire.create-notification');
    }
}
