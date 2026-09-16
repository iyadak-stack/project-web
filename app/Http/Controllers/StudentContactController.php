<?php

namespace App\Http\Controllers;

use App\Models\StudentContact;
use Illuminate\Http\Request;

class StudentContactController extends Controller
{
    // แสดงฟอร์มกรอก/แก้ไขข้อมูลติดต่อ
    public function edit($studentId)
    {
        $contact = StudentContact::where('student_id', $studentId)->first();

        return view('student-contacts.edit', compact('contact', 'studentId'));
    }

    // บันทึกข้อมูลติดต่อ (สร้างใหม่ ถ้ามีอยู่แล้วให้แก้ไขแทน)
    public function update(Request $request, $studentId)
    {
        $validated = $request->validate([
            'line_id' => 'nullable|string|max:50',
            'discord_id' => 'nullable|string|max:50',
            'google_meet_link' => 'nullable|string|max:255',
            'zoom_link' => 'nullable|string|max:255',
        ]);

        StudentContact::updateOrCreate(
            ['student_id' => $studentId],
            $validated
        );

        return back()->with('success', 'บันทึกข้อมูลติดต่อสำเร็จ');
    }
}
