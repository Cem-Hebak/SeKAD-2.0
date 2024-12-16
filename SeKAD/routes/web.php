<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [indexController::class], 'index');
