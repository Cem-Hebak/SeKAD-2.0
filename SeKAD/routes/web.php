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