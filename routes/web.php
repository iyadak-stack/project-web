<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentContactController;
use App\Http\Controllers\AuthController;

Route::view('/', 'welcome')->name('home');

// หน้า Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return 'ยินดีต้อนรับ! User ID ของคุณคือ: ' . session('user_id') . ' | Role ปัจจุบัน: ' . session('current_role');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

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