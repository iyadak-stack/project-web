<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // แสดงรายการแจ้งเตือนทั้งหมด
    public function index()
    {
        // สมมุติใช้ User ID = 'U001'
        $userId = 'U001';

        $notifications = Notification::where('Users_user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // กดอ่านแจ้งเตือน
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        return redirect()->back();
    }
}