<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // แสดงรายการนัดหมายทั้งหมด
    public function index()
    {
        $appointments = Appointment::with(['subject', 'location'])->get();
        return view('appointments.index', compact('appointments'));
    }

    // แสดงฟอร์มสร้างนัดใหม่
    public function create()
    {
        return view('appointments.create');
    }

    // บันทึกนัดหมายใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'tutor_id' => 'required|integer',
            'subject_id' => 'required|exists:subjects,id',
            'location_id' => 'nullable|exists:locations,id',
            'mode' => 'required|in:online,onsite',
            'appointment_datetime' => 'required|date|after:now',
        ]);

        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'สร้างนัดหมายสำเร็จ');
    }

    // แสดงรายละเอียดนัดหมาย 1 รายการ
    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    // ยืนยันนัดหมาย
    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);

        Notification::create([
            'appointment_id' => $appointment->id,
            'notification_type' => 'confirmed',
            'message' => 'นัดหมายได้รับการยืนยันแล้ว',
        ]);

        return back()->with('success', 'ยืนยันนัดหมายสำเร็จ');
    }

    // เลื่อนนัดหมาย
    public function reschedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_datetime' => 'required|date|after:now',
        ]);

        $appointment->update([
            'appointment_datetime' => $validated['appointment_datetime'],
            'status' => 'rescheduled',
        ]);

        Notification::create([
            'appointment_id' => $appointment->id,
            'notification_type' => 'rescheduled',
            'message' => 'นัดหมายถูกเลื่อนเวลาแล้ว',
        ]);

        return back()->with('success', 'เลื่อนนัดหมายสำเร็จ');
    }

    // ยกเลิกนัดหมาย
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        Notification::create([
            'appointment_id' => $appointment->id,
            'notification_type' => 'cancelled',
            'message' => 'นัดหมายถูกยกเลิกแล้ว',
        ]);

        return back()->with('success', 'ยกเลิกนัดหมายสำเร็จ');
    }

    // ลบนัดหมาย (ถ้าต้องการ)
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'ลบนัดหมายสำเร็จ');
    }
}