<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\StudentController;

Route::get('/assign-student', [StudentController::class, 'showAssignForm'])->name('assign-student');
Route::post('/assign-student', [StudentController::class, 'assignStudent'])->name('assign-student.submit');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');