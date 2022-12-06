<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->except('mine');
    }

    public function index()
    {
        $notifications = Notification::all();

        return view('notifications.index', ['notifications' => $notifications]);
    }

    public function mine()
    {
        $notifications = Notification::join('notification_user', 'notification_user.notification_id', '=', 'notifications.id', 'left')
            ->where('notification_user.user_id', '=', Auth::user()->id)
            ->orWhere('notifications.public', '=', 1)
            ->distinct()
            ->get(['notifications.*']);

        // return view('notifications.mine');
        return view('notifications.mine', ['notifications' => $notifications]);
    }

    public function create()
    {
        $users = User::where('id', '<>', 1)->get();
        return view('notifications.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['nullable', 'max:255'],
            'public' => ['nullable'],
        ]);

        $fields['public'] = $request->has('public');

        $notification = Notification::create($fields);

        if (!$fields['public'] && $request->users) {
            foreach ($request->users as $userId) {
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

        return redirect('/notifications')->with('Notification Created Successfully!');
    }

    public function show($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            throw new NotFoundHttpException();
        }

        return view('notifications.show', ['notification', $notification]);
    }

    public function edit($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            throw new NotFoundHttpException();
        }

        $users = User::with('notifications')->where('id', '<>', 1)->get();
        return view('notifications.edit', ['notification' => $notification, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['nullable', 'max:255'],
            'public' => ['nullable'],
        ]);

        $fields['public'] = $request->has('public');

        $notification->update($fields);
        
        $ids = UserNotification::where('notification_id', '=', $id)->get();
        UserNotification::destroy($ids);

        if ($fields['public'] == false && $request->users) {
            foreach ($request->users as $userId) {
                try {
                    UserNotification::create([
                        'notification_id' => $notification->id,
                        'user_id' => $userId
                    ]);
                } catch (\Throwable $th) {
                    return redirect('/notifications')->with('message', 'Book Created With Genres Errors!');
                }
            }
        }

        return redirect('/notifications')->with('Notification Updated Successfully!');
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            throw new NotFoundHttpException();
        }

        $notification->delete();
        return redirect('/notifications')->with('Notification Deleted Successfully!');
    }
}
