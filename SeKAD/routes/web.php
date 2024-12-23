<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\LanguageController;

// In routes/web.php
Route::get('/assign-student', function () {
    return view('assign-student');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[indexController::class],'index');

// Language switch route
Route::get('/switch-language/{lang}', [LanguageController::class, 'switchLanguage'])->name('switch.language');