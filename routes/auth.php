<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->get('', [MainController::class, 'index'])->name('home');
Route::middleware(['web','guest'])->any('register', [AuthController::class, 'register'])->name('register');
Route::middleware(['web', 'auth'])->get('logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['web', 'guest'])->name('login')->group(function () {
    Route::get('login', [LoginController::class, 'create']);
    Route::post('login', [LoginController::class, 'store']);
});
