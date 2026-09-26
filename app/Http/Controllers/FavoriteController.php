<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\TutorProfile;
use App\Models\Subject;

class FavoriteController extends Controller
{
    // เพิ่ม Tutor เป็นรายการโปรด
    public function storeTutor(TutorProfile $tutorProfile)
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'favoritable_type' => TutorProfile::class,
            'favoritable_id' => $tutorProfile->id,
        ]);

        return back()->with('success', 'เพิ่มติวเตอร์ในรายการโปรดแล้ว');
    }

    // ลบ Tutor ออกจากรายการโปรด
    public function destroyTutor(TutorProfile $tutorProfile)
    {
        Favorite::where('user_id', auth()->id())
            ->where('favoritable_type', TutorProfile::class)
            ->where('favoritable_id', $tutorProfile->id)
            ->delete();

        return back()->with('success', 'ลบติวเตอร์ออกจากรายการโปรดแล้ว');
    }

    // เพิ่ม Subject เป็นรายการโปรด
    public function storeSubject(Subject $subject)
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'favoritable_type' => Subject::class,
            'favoritable_id' => $subject->getKey(),
        ]);

        return back()->with('success', 'เพิ่มวิชาในรายการโปรดแล้ว');
    }

    // ลบ Subject ออกจากรายการโปรด
    public function destroySubject(Subject $subject)
    {
        Favorite::where('user_id', auth()->id())
            ->where('favoritable_type', Subject::class)
            ->where('favoritable_id', $subject->getKey())
            ->delete();

        return back()->with('success', 'ลบวิชาออกจากรายการโปรดแล้ว');
    }

    // แสดงรายการโปรดทั้งหมด
    public function tutorFavorites()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with('favoritable')
            ->get();

        $tutorFavorites = $favorites->where(
            'favoritable_type',
            TutorProfile::class
        );

        $subjectFavorites = $favorites->where(
            'favoritable_type',
            Subject::class
        );

        return view('tutor.favorites', compact(
            'tutorFavorites',
            'subjectFavorites'
        ));
    }
}
