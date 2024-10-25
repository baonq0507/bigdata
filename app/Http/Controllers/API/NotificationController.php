<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $page = 10;
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->paginate($this->page);
        return response()->json($notifications);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    }

    public function notificationUnread()
    {
     //lấy count
        $notifications = auth()->user()->unreadNotifications()->count();
        return response()->json([
            'count' => $notifications
        ]);
    }
}
