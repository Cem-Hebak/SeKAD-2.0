<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');

//Low Attendance Alert
Route::get('/low-attendance', [AttendanceController::class, 'getLowAttendance']);
Route::get('/attendance/warning', function () {
    return view('warning'); // Returns a Laravel Blade view
});
Route::get('/attendance/warning', [AttendanceController::class, 'warningPage']);