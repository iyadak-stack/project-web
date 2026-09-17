<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\TutorProfile;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function storeTutor(TutorProfile $tutorProfile): RedirectResponse
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'favoritable_type' => TutorProfile::class,
            'favoritable_id' => $tutorProfile->id,
        ]);

        return back()->with('success', 'Tutor added to favorites.');
    }

    public function destroyTutor(TutorProfile $tutorProfile): RedirectResponse
    {
        Favorite::where('user_id', auth()->id())
            ->where('favoritable_type', TutorProfile::class)
            ->where('favoritable_id', $tutorProfile->id)
            ->delete();

        return back()->with('success', 'Tutor removed from favorites.');
    }

    public function tutorFavorites()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->where('favoritable_type', TutorProfile::class)
            ->with('favoritable.user')
            ->get();

        return view('tutor.favorites', compact('favorites'));
    }
}
