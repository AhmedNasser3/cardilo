<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::latest()->paginate(10);
        return NotificationResource::collection($notifications);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read']);
    }
    public function markAllAsRead()
    {
        // بدون تحقق من المستخدم
        $now = Carbon::now();

        Notification::whereNull('read_at')->update(['read_at' => $now]);

        return response()->json(['message' => 'All notifications marked as read']);
    }

}