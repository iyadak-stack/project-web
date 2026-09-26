<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use App\Models\Subject;
use App\Models\Favorite;
use App\Models\Availability;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    // หน้า Home
    public function home()
    {
        $topTutors = TutorProfile::with(['user', 'subjects'])
            ->orderByDesc('average_rating')
            ->orderByDesc('experience_years')
            ->take(5)
            ->get();

        $topSubjects = Subject::with('tutors')
            ->take(5)
            ->get();

        return view('welcome', compact(
            'topTutors',
            'topSubjects'
        ));
    }

    // แสดง Tutor Profile ของผู้ใช้ที่กำลัง Login
    public function profile()
    {
        $tutorProfile = TutorProfile::where(
            'user_id',
            auth()->id()
        )->first();

        return view('tutor.profile', compact('tutorProfile'));
    }

    // แสดงหน้าแก้ไข Tutor Profile
    public function editProfile()
    {
        $tutorProfile = TutorProfile::where(
            'user_id',
            auth()->id()
        )->first();

        return view('tutor.edit-profile', compact('tutorProfile'));
    }

    // บันทึกการแก้ไข Tutor Profile
    public function updateProfile(Request $request)
    {
        // ตรวจสอบข้อมูลก่อนบันทึก
        $request->validate([
            'bio' => ['nullable', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'teaching_mode' => ['required', 'in:online,onsite,both'],
        ]);

        $tutorProfile = TutorProfile::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        $tutorProfile->update([
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
            'teaching_mode' => $request->teaching_mode,
        ]);

        return redirect()
            ->route('tutor.profile')
            ->with('success', 'Tutor profile updated successfully.');
    }

    // ค้นหา Tutor และ Subject
    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $tutors = TutorProfile::with(['user', 'subjects'])
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    // ค้นหาจากชื่อ Tutor
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })

                    // หรือค้นหาจากชื่อวิชา
                    ->orWhereHas('subjects', function ($subjectQuery) use ($search) {
                        $subjectQuery->where(
                            'subject_name',
                            'like',
                            "%{$search}%"
                        );
                    });
                });
            })
            ->orderByDesc('average_rating')
            ->orderByDesc('experience_years')
            ->get();

        // ดึงวิชาที่ Tutor ที่ค้นหาเจอสอน
        $subjects = $tutors
            ->flatMap(function ($tutor) {
                return $tutor->subjects;
            })
            ->unique('Subjec_id')
            ->values();

        // ถ้าค้นหาชื่อวิชาโดยตรง ให้นำวิชานั้นมาแสดงด้วย
        if ($search !== '') {

            $matchedSubjects = Subject::with('tutors.user')
                ->where(
                    'subject_name',
                    'like',
                    "%{$search}%"
                )
                ->get();

            $subjects = $subjects
                ->merge($matchedSubjects)
                ->unique('Subjec_id')
                ->values();
        }

        return view('tutor.search', compact(
            'tutors',
            'subjects',
            'search'
        ));
    }

    // แสดงอันดับ Tutor
    public function ranking()
    {
        $tutors = TutorProfile::with('user')
            ->orderByDesc('average_rating')
            ->orderByDesc('experience_years')
            ->get();

        return view('tutor.ranking', compact('tutors'));
    }

    // แสดงรายละเอียด Tutor
    public function show(TutorProfile $tutorProfile)
    {
        // โหลดข้อมูล Tutor และวิชาที่สอน
        $tutorProfile->load(['user', 'subjects']);

        // ดึงเวลาที่ Tutor ว่างในอนาคต
        $availabilities = Availability::where(
            'user_id',
            $tutorProfile->user_id
        )
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime')
            ->get();

        // ตรวจสอบว่า Tutor คนนี้ถูกบันทึกเป็น Favorite หรือไม่
        $isFavorite = Favorite::where(
            'user_id',
            auth()->id()
        )
            ->where('favoritable_type', TutorProfile::class)
            ->where('favoritable_id', $tutorProfile->id)
            ->exists();

        return view('tutor.show', compact(
            'tutorProfile',
            'availabilities',
            'isFavorite'
        ));
    }

    // แสดงหน้าจอง Tutor
    public function book(
        TutorProfile $tutorProfile,
        Availability $availability
    ) {
        // โหลดข้อมูล Tutor และวิชาที่สอน
        $tutorProfile->load(['user', 'subjects']);

        // หา Student Profile ของผู้ใช้ที่กำลัง Login
        $studentProfile = StudentProfile::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        // ตรวจสอบว่าเวลาที่เลือกเป็นของ Tutor คนนี้จริง
        // และยังไม่ผ่านไป
        $selectedAvailability = Availability::where(
            'availability_id',
            $availability->availability_id
        )
            ->where('user_id', $tutorProfile->user_id)
            ->where('start_datetime', '>=', now())
            ->firstOrFail();

        return view('tutor.booking', compact(
            'tutorProfile',
            'studentProfile',
            'selectedAvailability'
        ));
    }

    // บันทึกการจอง Tutor
    public function saveBooking(
        Request $request,
        TutorProfile $tutorProfile,
        Availability $availability
    ) {
        // ตรวจสอบว่ามีการเลือกวิชา
        $request->validate([
            'subject_id' => ['required'],
        ]);

        // หา Student Profile ของผู้ใช้ที่กำลัง Login
        $student = StudentProfile::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        // ตรวจสอบว่าวิชาที่เลือกเป็นวิชาที่ Tutor คนนี้สอน
        $subject = $tutorProfile->subjects()
            ->where('Subjec_id', $request->subject_id)
            ->firstOrFail();

        // ตรวจสอบว่าเวลาที่เลือกเป็นของ Tutor คนนี้
        // และยังสามารถจองได้
        $selectedAvailability = Availability::where(
            'availability_id',
            $availability->availability_id
        )
            ->where('user_id', $tutorProfile->user_id)
            ->where('start_datetime', '>=', now())
            ->firstOrFail();

        // สร้างรหัสนัดหมาย
        $appointmentId = 'APP' . rand(1000000, 9999999);

        // บันทึกข้อมูลการนัดหมาย
        \DB::table('appointments')->insert([
            'Appointment_id' => $appointmentId,
            'mode' => $tutorProfile->teaching_mode,
            'appointment_datetime' => $selectedAvailability->start_datetime,
            'status' => 'pending',
            'start_datetime' => $selectedAvailability->start_datetime,
            'end_datetime' => $selectedAvailability->end_datetime,
            'Subject_subject_id' => $subject->Subjec_id,
            'Tutor_profiles_tutor_id' => $tutorProfile->id,
            'Student_profiles_student_id' => $student->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // สร้างรหัส Notification
        $notificationId = 'NOT' . rand(1000000, 9999999);

        // แจ้ง Tutor ว่ามีการจองใหม่
        \DB::table('notifications')->insert([
            'Notification_id' => $notificationId,
            'notification_type' => 'booking',
            'message' => 'มีการจองนัดหมายใหม่รอยืนยัน',
            'is_read' => false,
            'Users_user_id' => $tutorProfile->user_id,
            'NotificationType_notification_type_id' => 'TYPE01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // กลับไปหน้า Tutor Profile
        return redirect()
            ->route('tutor.show', $tutorProfile)
            ->with('success', 'จองติวเตอร์สำเร็จ');
    }
}