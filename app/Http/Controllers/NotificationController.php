<?php

namespace App\Http\Controllers;

use App\Events\NotificationRead;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = request()->user();

        return $user->notifications()->paginate(10);
    }

    public function unreadCount()
    {
        return request()->user()->unreadNotifications()->count();
    }

    public function markAdRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        broadcast(new NotificationRead($notification))->toOthers();

        return $notification;
    }

    public function show(DatabaseNotification $notification)
    {
        return $notification;
    }
}
