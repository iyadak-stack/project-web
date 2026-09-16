<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    // แสดงรายการแจ้งเตือนทั้งหมด
    public function index()
    {
        $notifications = Notification::with('appointment')
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // ลบแจ้งเตือน (ถ้าต้องการ)
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with('success', 'ลบการแจ้งเตือนสำเร็จ');
    }
}
