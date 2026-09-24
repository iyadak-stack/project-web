<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CheckScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentContactController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
    Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::get('/availabilities/history', [AvailabilityController::class, 'history'])->name('availabilities.history');
    Route::get('/availabilities/{availability}/edit', [AvailabilityController::class, 'edit'])->name('availabilities.edit');
    Route::put('/availabilities/{availability}', [AvailabilityController::class, 'update'])->name('availabilities.update');
    Route::delete('/availabilities/{availability}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');
    Route::get('/schedule/check', [CheckScheduleController::class, 'index'])->name('schedule.check');
    Route::post('/schedule/check', [CheckScheduleController::class, 'check'])->name('schedule.check.results');

    // ===== จัดการรายวิชา =====
    Route::resource('subjects', SubjectController::class);

    // ===== การนัดหมาย =====
    Route::resource('appointments', AppointmentController::class)->except(['edit', 'update']);
    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // ===== ระบบแจ้งเตือน =====
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // ===== ข้อมูลติดต่อของนักเรียน =====
    Route::get('/student-contacts/{studentId}/edit', [StudentContactController::class, 'edit'])->name('student-contacts.edit');
    Route::put('/student-contacts/{studentId}', [StudentContactController::class, 'update'])->name('student-contacts.update');
});

require __DIR__.'/settings.php';
