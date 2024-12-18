<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\LowAttendanceController;

// In routes/web.php
Route::get('/assign-student', function () {
    return view('assign-student');
});

use App\Http\Controllers\LanguageController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');

//Low Attendance Alert
// Route::get('/low-attendance', [AttendanceController::class, 'getLowAttendance']);
// Route::get('/attendance/warning', function () {
//     return view('warning'); // Returns a Laravel Blade view
// });
// Route::get('/attendance/warning', [AttendanceController::class, 'warningPage']);
Route::get('/low-attendance', [LowAttendanceController::class, 'index'])->name('low-attendance');
// Language switch route
Route::get('/switch-language/{lang}', [LanguageController::class, 'switchLanguage'])->name('switch.language');
Route::get('/', [indexController::class], 'index');
