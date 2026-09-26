<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use App\Models\Subject;
use App\Models\Favorite;
use App\Models\Availability;
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
}
