<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('subjects', App\Http\Controllers\SubjectController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('teachers', App\Http\Controllers\TeacherController::class);
    Route::resource('schedules', App\Http\Controllers\ScheduleController::class);
    Route::get('/enroll', [App\Http\Controllers\Student\EnrollmentController::class, 'index'])->name('enroll.index');
    Route::post('/enroll', [App\Http\Controllers\Student\EnrollmentController::class, 'store'])->name('enroll.store');
    Route::get('/admin/enrollments', [App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('admin.enrollments.index');
    // Rota para processar a aprovação/rejeição
    Route::put('/admin/enrollments/{enrollment}', [App\Http\Controllers\Admin\EnrollmentController::class, 'update'])->name('admin.enrollments.update');

});
    Route::get('/enroll', [App\Http\Controllers\Student\EnrollmentController::class, 'index'])->name('enroll.index');
    Route::post('/enroll', [App\Http\Controllers\Student\EnrollmentController::class, 'store'])->name('enroll.store');
    Route::get('/my-schedule', [App\Http\Controllers\Student\EnrollmentController::class, 'mySchedule'])->name('my-schedule.index');



require __DIR__.'/auth.php';
