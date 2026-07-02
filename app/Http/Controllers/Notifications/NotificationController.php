<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Repository\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notification;

    public function __construct(NotificationRepositoryInterface $notification)
    {
        $this->notification = $notification;
    }

    public function index()
    {
        $notifications = $this->notification->getUserNotifications(auth()->id());
        return view('pages.Notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $this->notification->markAsRead($id);
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        $this->notification->markAllAsRead(auth()->id());
        return redirect()->back();
    }

    public function unreadCount()
    {
        return response()->json(['count' => $this->notification->getUnreadCount(auth()->id())]);
    }
}