<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\FavoriteController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/tutor/profile', [TutorController::class, 'profile'])
        ->name('tutor.profile');
    
    Route::get('/tutor/profile/edit', [TutorController::class, 'editProfile'])
        ->name('tutor.profile.edit');

    Route::put('/tutor/profile', [TutorController::class, 'updateProfile'])
        ->name('tutor.profile.update');

    Route::post('/tutor/{tutorProfile}/favorite', [FavoriteController::class, 'storeTutor'])
        ->name('tutor.favorite.store');

    Route::delete('/tutor/{tutorProfile}/favorite', [FavoriteController::class, 'destroyTutor'])
        ->name('tutor.favorite.destroy');
    
    Route::get('/tutors', [TutorController::class, 'search'])
        ->name('tutor.search');

    Route::get('/tutors/ranking', [TutorController::class, 'ranking'])
        ->name('tutor.ranking');

    Route::get('/tutors/favorites', [FavoriteController::class, 'tutorFavorites'])
        ->name('tutor.favorites');
});

require __DIR__.'/settings.php';
