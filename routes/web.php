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
use App\Http\Controllers\HealthCardioIncidenceAllController;
use App\Http\Controllers\HealthCardioMortalityController;
use App\Http\Controllers\HtIncidence100kController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// SQL Server test
Route::get('/sqlsrv-test', [SqlsrvTestController::class, 'index'])->name('sqlsrv.test');

// ======================
// Household
// ======================
Route::get('/household_64', [Household64Controller::class, 'index'])->name('household_64');

// ======================
// Welfare
// ======================
Route::get('/welfare', [WelfareController::class, 'index'])->name('welfare.index');
Route::get('/welfare/export', [WelfareController::class, 'export'])->name('welfare.export');

// ======================
// Health
// ======================

// หน้า health หลัก
Route::get('/health', [HealthController::class, 'index'])->name('health.index');

// export
Route::get('/health/export', [HealthController::class, 'export'])->name('health.export');

// 👉 health_status
Route::get('/health-status', function () {
    return view('health.health_status');
})->name('health_status');

// 👉 cardio menu
Route::get('/health/cardio-menu', function () {
    return view('health.cardio-menu');
})->name('health.cardio.menu');

// ======================
// Cardio
// ======================
Route::get('/health/cardio-incidence', [CardioIncidenceController::class, 'index'])
    ->name('health.cardio_incidence');

Route::get('/health/cardio-incidence-all', [HealthCardioIncidenceAllController::class, 'index'])
    ->name('health.cardio-incidence-all');

Route::get('/health/cardio-incidence-all/export', [HealthCardioIncidenceAllController::class, 'export'])
    ->name('health.cardio-incidence-all.export');

Route::get('/health/cardio-mortality', [HealthCardioMortalityController::class, 'index'])
    ->name('health.cardio-mortality');

Route::get('/health/cardio-mortality/export', [HealthCardioMortalityController::class, 'export'])
    ->name('health.cardio-mortality.export');

// ======================
// Other Health
// ======================
Route::get('/health/mortality-cause', fn() => 'หน้าสาเหตุการป่วย/ตาย')->name('health.mortality_cause');
Route::get('/health/occupation-environment', fn() => 'หน้าโรคจากอาชีพ')->name('health.occupation_environment');
Route::get('/health/air-pollution', fn() => 'หน้าโรคจากมลพิษ')->name('health.air_pollution');

// ======================
// Housing
// ======================
Route::get('/housing', [HousingPhysicalController::class, 'dashboard'])->name('housing.dashboard');
Route::get('/housing/map', [HousingPhysicalController::class, 'map'])->name('housing.map');
Route::get('/housing/cases', [HousingPhysicalController::class, 'cases'])->name('housing.cases');
Route::get('/housing/house/{houseId}', [HousingPhysicalController::class, 'show'])->name('housing.show');

// Help
Route::get('/housing/house/{houseId}/help/create', [HelpRecordController::class, 'create'])->name('help.create');
Route::post('/housing/house/{houseId}/help', [HelpRecordController::class, 'store'])->name('help.store');
Route::get('/help-records', [HelpRecordController::class, 'index'])->name('help_records.index');

// ======================
// Auth
// ======================
Route::get('/register', fn() => view('register'))->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// test
Route::get('/test', fn() => redirect()->route('health.index'))->name('test.redirect');

// export ncd
Route::get('/health/ncd-major/export', [CardioIncidenceController::class, 'export'])
    ->name('cardio.export');

    Route::get('/health/ht-incidence-100k', [HtIncidence100kController::class, 'index'])
    ->name('ht.incidence100k');

Route::get('/health/ht-incidence-100k/export', [HtIncidence100kController::class, 'export'])
    ->name('ht.incidence.100k.export');
    Route::get('/test-speed', function () {
    return 'ok';
});

