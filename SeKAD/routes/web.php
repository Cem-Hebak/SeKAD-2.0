<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::post('/students/assign', [StudentController::class, 'assign'])->name('students.assign');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');