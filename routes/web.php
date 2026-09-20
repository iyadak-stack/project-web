<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TutorController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentContactController;

Route::get('/', [TutorController::class, 'home'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    // =========================
    // Tutor Profile
    // =========================

    Route::get('/tutor/profile', [TutorController::class, 'profile'])
        ->name('tutor.profile');

    Route::get('/tutor/profile/edit', [TutorController::class, 'editProfile'])
        ->name('tutor.profile.edit');

    Route::put('/tutor/profile', [TutorController::class, 'updateProfile'])
        ->name('tutor.profile.update');


    // =========================
    // Tutor Favorite
    // =========================

    Route::post('/tutor/{tutorProfile}/favorite', [FavoriteController::class, 'storeTutor'])
        ->name('tutor.favorite.store');

    Route::delete('/tutor/{tutorProfile}/favorite', [FavoriteController::class, 'destroyTutor'])
        ->name('tutor.favorite.destroy');


    // =========================
    // Search / Ranking / Tutor
    // =========================

    Route::get('/tutors', [TutorController::class, 'search'])
        ->name('tutor.search');

    Route::get('/tutors/ranking', [TutorController::class, 'ranking'])
        ->name('tutor.ranking');

    Route::get('/tutors/favorites', [FavoriteController::class, 'tutorFavorites'])
        ->name('tutor.favorites');

    Route::get('/tutors/{tutorProfile}', [TutorController::class, 'show'])
        ->name('tutor.show');


    // =========================
    // Subjects
    // =========================

    Route::resource('subjects', SubjectController::class);


    // =========================
    // Appointments
    // =========================

    Route::resource('appointments', AppointmentController::class)
        ->except(['edit', 'update']);

    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm');

    Route::post('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])
        ->name('appointments.reschedule');

    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');


    // =========================
    // Notifications
    // =========================

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');


    // =========================
    // Student Contacts
    // =========================

    Route::get('/student-contacts/{studentId}/edit', [StudentContactController::class, 'edit'])
        ->name('student-contacts.edit');

    Route::put('/student-contacts/{studentId}', [StudentContactController::class, 'update'])
        ->name('student-contacts.update');
});

require __DIR__.'/settings.php';