<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\PasswordResetController;

// Handle the password reset form submission
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [indexController::class], 'index');
