<?php

use App\Http\Middleware\CheckSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckSessionExpiry;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;

Route::withoutMiddleware([CheckSession::class])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('proseslogin');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([CheckSession::class, CheckSessionExpiry::class])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/presensi', [PresensiController::class, 'presensi'])->name('presensi');
    Route::post('/addPresensi', [PresensiController::class, 'addPresensi'])->name('addPresensi');
});


