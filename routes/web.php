<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TutorController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CheckScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\RoleController;

Route::get('/', [TutorController::class, 'home'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    // =========================
    // โปรไฟล์ติวเตอร์ (Tutor Profile)
    // =========================

    Route::get('/tutor/profile', [TutorController::class, 'profile'])
        ->middleware('role:tutor')
        ->name('tutor.profile');

    Route::get('/tutor/profile/edit', [TutorController::class, 'editProfile'])
        ->middleware('role:tutor')
        ->name('tutor.profile.edit');

    Route::post('/tutor/profile', [TutorController::class, 'updateProfile'])
        ->middleware('role:tutor')
        ->name('tutor.profile.update');


    // =========================
    // รายการโปรดติวเตอร์ (Tutor Favorite)
    // =========================

    Route::post('/tutor/{tutorProfile}/favorite', [FavoriteController::class, 'storeTutor'])
        ->name('tutor.favorite.store');

    Route::post('/tutor/{tutorProfile}/favorite/remove', [FavoriteController::class, 'destroyTutor'])
        ->name('tutor.favorite.destroy');


    // =========================
    // ค้นหา / จัดอันดับติวเตอร์ (Search / Ranking / Tutor)
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
    // จัดการรายวิชา (Subjects)
    // =========================

    Route::resource('subjects', SubjectController::class);


    // =========================
    // ตารางเวลาและความพร้อม (Availability & Schedule Check)
    // =========================

    Route::get('/availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
    Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::get('/availabilities/history', [AvailabilityController::class, 'history'])->name('availabilities.history');
    Route::get('/availabilities/{availability}/edit', [AvailabilityController::class, 'edit'])->name('availabilities.edit');
    Route::put('/availabilities/{availability}', [AvailabilityController::class, 'update'])->name('availabilities.update');
    Route::delete('/availabilities/{availability}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');

    Route::get('/schedule/check', [CheckScheduleController::class, 'index'])->name('schedule.check');
    Route::post('/schedule/check', [CheckScheduleController::class, 'check'])->name('schedule.check.results');


    // =========================
    // การนัดหมาย (Appointments)
    // =========================

    Route::resource('appointments', AppointmentController::class)
        ->except(['edit', 'update']);

    Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);

    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm');

    Route::post('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])
        ->name('appointments.reschedule');

    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');


    // =========================
    // ระบบแจ้งเตือน (Notifications)
    // =========================

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');


    // =========================
    // โปรไฟล์นักเรียน (Student Profile)
    // =========================

    Route::get('/student/profile', [StudentProfileController::class, 'profile'])
        ->middleware('role:student')
        ->name('student.profile');

    Route::get('/student/profile/edit', [StudentProfileController::class, 'editProfile'])
        ->middleware('role:student')
        ->name('student.profile.edit');

    Route::post('/student/profile', [StudentProfileController::class, 'updateProfile'])
        ->middleware('role:student')
        ->name('student.profile.update');


    // =========================
    // ข้อมูลติดต่อของนักเรียน (Student Contacts)
    // =========================

    Route::get('/student-contacts/{studentId}/edit', [ContactController::class, 'edit'])
        ->name('student-contacts.edit');

    Route::put('/student-contacts/{studentId}', [ContactController::class, 'update'])
        ->name('student-contacts.update');


    // =========================
    // สลับบทบาทผู้ใช้ (Role Switching)
    // =========================

    Route::post('/switch-role', [RoleController::class, 'switchRole'])
        ->name('role.switch');
});

require __DIR__.'/settings.php';