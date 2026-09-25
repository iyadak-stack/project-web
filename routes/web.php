<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CheckScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

// ===== ตารางเวลาและความพร้อม (Availability & Schedule Check) =====
Route::get('/availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
Route::get('/availabilities/history', [AvailabilityController::class, 'history'])->name('availabilities.history');
Route::get('/availabilities/{availability}/edit', [AvailabilityController::class, 'edit'])->name('availabilities.edit');
Route::put('/availabilities/{availability}', [AvailabilityController::class, 'update'])->name('availabilities.update');
Route::delete('/availabilities/{availability}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');

Route::get('/schedule/check', [CheckScheduleController::class, 'index'])->name('schedule.check');
Route::post('/schedule/check', [CheckScheduleController::class, 'check'])->name('schedule.check.results');

// ===== จัดการรายวิชา (Subjects) =====
Route::resource('subjects', SubjectController::class);

// ===== การนัดหมาย (Appointments) =====
Route::resource('appointments', AppointmentController::class)->except(['edit', 'update']);
Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);
Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
Route::post('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

// ===== ระบบแจ้งเตือน (Notifications) =====
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

// ===== ข้อมูลติดต่อของนักเรียน (Student Contacts) =====
Route::get('/student-contacts/{studentId}/edit', [ContactController::class, 'edit'])->name('student-contacts.edit');
Route::put('/student-contacts/{studentId}', [ContactController::class, 'update'])->name('student-contacts.update');

require __DIR__.'/settings.php';