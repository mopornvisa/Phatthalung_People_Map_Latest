<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SqlsrvTestController;
use App\Http\Controllers\Household64Controller;
use App\Http\Controllers\WelfareController;
use App\Http\Controllers\HealthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// หน้าแรก → ไปหน้า test ก่อน
Route::get('/', function () {
    return redirect()->route('sqlsrv.test');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ทดสอบ SQL Server
Route::get('/sqlsrv-test', [SqlsrvTestController::class, 'index'])->name('sqlsrv.test');

// ข้อมูลครัวเรือน
Route::get('/household_64', [Household64Controller::class, 'index'])->name('household_64');

// Welfare

Route::get('/welfare', [WelfareController::class, 'index'])->name('welfare.index');
Route::get('/welfare/export', [WelfareController::class, 'export'])->name('welfare.export');

// Health
Route::get('/health', [HealthController::class, 'index'])->name('health.index');
Route::get('/health/export', [HealthController::class, 'export'])->name('health.export');

// Housing dashboard
Route::get('/housing', function () {
    return redirect()->route('household_64');
})->name('housing.dashboard');

// Register
Route::get('/register', function () {
    return view('register');
})->name('register.form');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// test เดิม → ไป health
Route::get('/test', function () {
    return redirect()->route('health.index');
})->name('test.redirect');