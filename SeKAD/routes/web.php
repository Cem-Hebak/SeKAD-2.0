<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;

// In routes/web.php
Route::get('/assign-student', function () {
    return view('assign-student');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');