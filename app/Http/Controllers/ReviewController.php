<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with([
            'appointment.studentProfile.user',
            'tutorProfile'
        ])->get();

        dd([
            'logged_in_user_id' => auth()->id(),
            'current_role' => auth()->user()->current_role,

            'reviews' => $reviews->map(function ($review) {
                return [
                    'review_id' => $review->Review_id,

                    'appointment_id' =>
                        $review->Appointment_Appointment_id,

                    'student_profile_id' =>
                        $review->appointment?->studentProfile?->id,

                    'student_user_id' =>
                        $review->appointment?->studentProfile?->user_id,

                    'tutor_id' =>
                        $review->Tutor_profiles_tutor_id,
                ];
            })->values(),
        ]);
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'Comment' => ['required', 'string'],
            'Appointment_Appointment_id' => ['required', 'string', 'size:10'],
            'Tutor_profiles_tutor_id' => ['required', 'string'],
        ]);

        Review::create([
            'Review_id' => strtoupper(\Illuminate\Support\Str::random(10)),
            'rating' => $validated['rating'],
            'Comment' => $validated['Comment'],
            'Appointment_Appointment_id' => $validated['Appointment_Appointment_id'],
            'Tutor_profiles_tutor_id' => $validated['Tutor_profiles_tutor_id'],
        ]);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'บันทึกรีวิวเรียบร้อยแล้ว');
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'Comment' => ['required', 'string'],
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'Comment' => $validated['Comment'],
        ]);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'แก้ไขรีวิวเรียบร้อยแล้ว');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()
            ->route('reviews.index')
            ->with('success', 'ลบรีวิวเรียบร้อยแล้ว');
    }
}
