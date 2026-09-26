<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    // แสดงข้อมูลโปรไฟล์นักเรียน
    public function profile()
    {
        $userId = auth()->id();
        $studentProfile = StudentProfile::where('user_id', $userId)->first();

        return view('student.profile', compact('studentProfile'));
    }

    // แสดงหน้าแก้ไขโปรไฟล์นักเรียน
    public function editProfile()
    {
        $userId = auth()->id();
        $studentProfile = StudentProfile::where('user_id', $userId)->first();

        return view('student.edit-profile', compact('studentProfile'));
    }

    // บันทึกข้อมูลโปรไฟล์นักเรียน
    public function updateProfile(Request $request)
    {
        $request->validate([
            'bio' => ['nullable', 'string'],
        ]);

        $userId = auth()->id();

        // ถ้ามีโปรไฟล์แล้วให้แก้ไข ถ้ายังไม่มีให้สร้างใหม่
        StudentProfile::updateOrCreate(
            ['user_id' => $userId],
            ['bio' => $request->bio]
        );

        return redirect()
            ->route('student.profile')
            ->with('success', 'อัปเดตโปรไฟล์นักเรียนเรียบร้อยแล้ว');
    }
}