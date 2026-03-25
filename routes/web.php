<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SqlsrvTestController;
use App\Http\Controllers\Household64Controller;
use App\Http\Controllers\WelfareController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HousingPhysicalController;
use App\Http\Controllers\HelpRecordController;
use App\Http\Controllers\CardioIncidenceController;

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

// ======================
// Health
// ======================
Route::get('/health', [HealthController::class, 'index'])->name('health.index');
Route::get('/health/export', [HealthController::class, 'export'])->name('health.export');

// หน้าเมนูสถานะสุขภาพ
Route::get('/health-status', function () {
    return view('health.health-status');
})->name('health.status');

// อัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด
Route::get('/health/cardio-incidence', [CardioIncidenceController::class, 'index'])
    ->name('health.cardio_incidence');


Route::get('/health/mortality-cause', function () {
    return 'หน้าสาเหตุการป่วย/ตาย';
})->name('health.mortality_cause');

Route::get('/health/occupation-environment', function () {
    return 'หน้าโรคจากการประกอบอาชีพและสิ่งแวดล้อม';
})->name('health.occupation_environment');

Route::get('/health/air-pollution', function () {
    return 'หน้าการป่วยด้วยโรคจากมลพิษทางอากาศ';
})->name('health.air_pollution');

// ======================
// Housing
// ======================
Route::get('/housing', [HousingPhysicalController::class, 'dashboard'])->name('housing.dashboard');
Route::get('/housing/map', [HousingPhysicalController::class, 'map'])->name('housing.map');
Route::get('/housing/cases', [HousingPhysicalController::class, 'cases'])->name('housing.cases');
Route::get('/housing/house/{houseId}', [HousingPhysicalController::class, 'show'])->name('housing.show');

// Help records (housing)
Route::get('/housing/house/{houseId}/help/create', [HelpRecordController::class, 'create'])->name('help.create');
Route::post('/housing/house/{houseId}/help', [HelpRecordController::class, 'store'])->name('help.store');
Route::get('/help-records', [HelpRecordController::class, 'index'])->name('help_records.index');

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