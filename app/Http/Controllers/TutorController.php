<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use App\Models\Subject;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function profile()
    {
        $tutorProfile = TutorProfile::where('user_id', auth()->id())->first();

        return view('tutor.profile', compact('tutorProfile'));
    }

    public function editProfile()
    {
        $tutorProfile = TutorProfile::where('user_id', auth()->id())->first();

        return view('tutor.edit-profile', compact('tutorProfile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'bio' => ['nullable', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'teaching_mode' => ['required', 'in:online,onsite,both'],
        ]);

        $tutorProfile = TutorProfile::where('user_id', auth()->id())->firstOrFail();

        $tutorProfile->update([
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
            'teaching_mode' => $request->teaching_mode,
        ]);

        return redirect()
            ->route('tutor.profile')
            ->with('success', 'Tutor profile updated successfully.');
    }
    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $tutors = TutorProfile::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('average_rating')
            ->get();

        $subjects = Subject::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('subject_name', 'like', "%{$search}%");
            })
            ->get();

        return view('tutor.search', compact(
            'tutors',
            'subjects',
            'search'
        ));
    }
    public function ranking()
    {
        $tutors = TutorProfile::with('user')
            ->orderByDesc('average_rating')
            ->orderByDesc('experience_years')
            ->get();

        return view('tutor.ranking', compact('tutors'));
    }
}
