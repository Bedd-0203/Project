<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SdaController as AdminSda;
use App\Http\Controllers\Admin\NewsController as AdminNews;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\NotificationController as AdminNotif;

// PETUGAS
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\SdaController as PetugasSda;
use App\Http\Controllers\Petugas\NewsController as PetugasNews;

// MASYARAKAT
use App\Http\Controllers\Masyarakat\DashboardController as MasyarakatDashboard;
use App\Http\Controllers\Masyarakat\ReportController as MasyarakatReport;

// AUTH
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/sda', [HomeController::class, 'dataSda']);
Route::get('/detail-sda/{id}', [HomeController::class, 'detailSda']);

Route::get('/news', [HomeController::class, 'berita']);
Route::get('/detail-news/{id}', [HomeController::class, 'detailNews']);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// 🔥 FIX: logout harus pakai auth middleware biar aman
Route::get('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('sda', AdminSda::class);
        Route::resource('news', AdminNews::class);
        Route::resource('user', AdminUser::class);

        Route::get('/notifications', [AdminNotif::class, 'index'])->name('notifications');

        Route::post('/notifications', [AdminNotif::class, 'store'])->name('notifications.store');
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');

        Route::resource('sda', PetugasSda::class);
        Route::resource('news', PetugasNews::class);
});

/*
|--------------------------------------------------------------------------
| MASYARAKAT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('masyarakat')
    ->name('masyarakat.')
    ->group(function () {

        Route::get('/dashboard', [MasyarakatDashboard::class, 'index'])->name('dashboard');

        Route::resource('report', MasyarakatReport::class);
});