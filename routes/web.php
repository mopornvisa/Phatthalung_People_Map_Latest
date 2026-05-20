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
use App\Http\Controllers\DmIncidence100kController;
use App\Http\Controllers\CopdIncidence100kController;
use App\Http\Controllers\AsthmaIncidence100kController;
use App\Http\Controllers\CardioCompareController;
use App\Http\Controllers\HtIncidenceAllController;
use App\Http\Controllers\HtMortalityController;
use App\Http\Controllers\StrokeIncidenceAllController;
use App\Http\Controllers\DmIncidenceAllController;
use App\Http\Controllers\DmMortalityController;
use App\Http\Controllers\CopdIncidenceAllController;
use App\Http\Controllers\CopdMortalityController;
use App\Http\Controllers\BcIncidenceAllController;
use App\Http\Controllers\CcIncidenceAllController;
use App\Http\Controllers\EmphIncidenceAllController;
use App\Http\Controllers\LcIncidenceAllController;
use App\Http\Controllers\DeathDashboardController;
use App\Http\Controllers\DeathSummaryManageController;
use App\Http\Controllers\EducationDashboardController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\ForestResourceController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Home / Main
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('home'))->name('home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/register', fn() => view('register'))
    ->name('register.form');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login.form');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.store');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');


Route::middleware(['login.required'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/sqlsrv-test', [SqlsrvTestController::class, 'index'])
    ->name('sqlsrv.test');

Route::get('/test', fn() => redirect()->route('health.index'))
    ->name('test.redirect');

Route::get('/test-speed', fn() => 'ok');

/*
|--------------------------------------------------------------------------
| Household
|--------------------------------------------------------------------------
*/


Route::prefix('household_64')->group(function () {
    Route::get('/', [Household64Controller::class, 'index'])
        ->name('household_64');

    Route::get('/export', [Household64Controller::class, 'export'])
        ->name('household_64.export');
});

/*
|--------------------------------------------------------------------------
| Welfare
|--------------------------------------------------------------------------
*/

Route::prefix('welfare')->group(function () {
    Route::get('/', [WelfareController::class, 'index'])
        ->name('welfare.index');

    Route::get('/export', [WelfareController::class, 'export'])
        ->name('welfare.export');
});

/*
|--------------------------------------------------------------------------
| Housing / Help Records
|--------------------------------------------------------------------------
*/

Route::prefix('housing')->group(function () {
    Route::get('/', [HousingPhysicalController::class, 'dashboard'])
        ->name('housing.dashboard');

    Route::get('/map', [HousingPhysicalController::class, 'map'])
        ->name('housing.map');

    Route::get('/cases', [HousingPhysicalController::class, 'cases'])
        ->name('housing.cases');

    Route::get('/house/{houseId}', [HousingPhysicalController::class, 'show'])
        ->name('housing.show');

    Route::get('/house/{houseId}/help/create', [HelpRecordController::class, 'create'])
        ->name('help_records.create');

    Route::post('/house/{houseId}/help', [HelpRecordController::class, 'store'])
        ->name('help_records.store');
});

Route::get('/help-records', [HelpRecordController::class, 'index'])
    ->name('help_records.index');

/*
|--------------------------------------------------------------------------
| Health Main
|--------------------------------------------------------------------------
*/

Route::prefix('health')->group(function () {
    Route::get('/', [HealthController::class, 'index'])
        ->name('health.index');

    Route::get('/export', [HealthController::class, 'export'])
        ->name('health.export');

    Route::get('/status', fn() => view('health.health_status'))
        ->name('health_status');

    Route::get('/cardio-menu', fn() => view('health.cardio-menu'))
        ->name('health.cardio.menu');

    Route::get('/mortality-cause', fn() => 'หน้าสาเหตุการป่วย/ตาย')
        ->name('health.mortality_cause');

    Route::get('/occupation-environment', fn() => 'หน้าโรคจากอาชีพ')
        ->name('health.occupation_environment');

    Route::get('/air-pollution', fn() => 'หน้าโรคจากมลพิษ')
        ->name('health.air_pollution');

    Route::get('/ncd-major/export', [CardioIncidenceController::class, 'export'])
        ->name('cardio.export');
});

/*
|--------------------------------------------------------------------------
| Health - Cardio
|--------------------------------------------------------------------------
*/

Route::prefix('health')->group(function () {
    Route::get('/cardio-incidence', [CardioIncidenceController::class, 'index'])
        ->name('health.cardio_incidence');

    Route::get('/cardio-incidence-all', [HealthCardioIncidenceAllController::class, 'index'])
        ->name('health.cardio-incidence-all');

    Route::get('/cardio-incidence-all/export', [HealthCardioIncidenceAllController::class, 'export'])
        ->name('health.cardio-incidence-all.export');

    Route::get('/cardio-mortality', [HealthCardioMortalityController::class, 'index'])
        ->name('health.cardio-mortality');

    Route::get('/cardio-mortality/export', [HealthCardioMortalityController::class, 'export'])
        ->name('health.cardio-mortality.export');

    Route::get('/cardio-compare', [CardioCompareController::class, 'index'])
        ->name('health.cardio_compare');

    Route::get('/cardio-compare/export', [CardioCompareController::class, 'export'])
        ->name('health.cardio_compare.export');
});

/*
|--------------------------------------------------------------------------
| Health - Incidence 100k
|--------------------------------------------------------------------------
*/

Route::prefix('health')->group(function () {
    Route::get('/ht-incidence-100k', [HtIncidence100kController::class, 'index'])
        ->name('ht.incidence100k');

    Route::get('/ht-incidence-100k/export', [HtIncidence100kController::class, 'export'])
        ->name('ht.incidence.100k.export');

    Route::get('/dm-incidence-100k', [DmIncidence100kController::class, 'index'])
        ->name('dm.incidence.100k');

    Route::get('/dm-incidence-100k/export', [DmIncidence100kController::class, 'export'])
        ->name('dm.incidence.100k.export');

    Route::get('/copd-incidence-100k', [CopdIncidence100kController::class, 'index'])
        ->name('copd.incidence.100k');

    Route::get('/copd-incidence-100k/export', [CopdIncidence100kController::class, 'export'])
        ->name('copd.incidence.100k.export');

    Route::get('/as-incidence-100k', [AsthmaIncidence100kController::class, 'index'])
        ->name('as.incidence.100k');

    Route::get('/as-incidence-100k/export', [AsthmaIncidence100kController::class, 'export'])
        ->name('as.incidence.100k.export');
});

/*
|--------------------------------------------------------------------------
| Health - Other Disease Dashboards
|--------------------------------------------------------------------------
*/

Route::prefix('health')->group(function () {
    Route::get('/ht-incidence-all', [HtIncidenceAllController::class, 'index'])
        ->name('health.ht-incidence-all');

    Route::get('/ht-incidence-all/export', [HtIncidenceAllController::class, 'export'])
        ->name('health.ht-incidence-all.export');

    Route::get('/ht-mortality', [HtMortalityController::class, 'index'])
        ->name('health.ht-mortality');

    Route::get('/ht-mortality/export', [HtMortalityController::class, 'export'])
        ->name('health.ht-mortality.export');

    Route::get('/stroke-incidence-all', [StrokeIncidenceAllController::class, 'index'])
        ->name('health.stroke-incidence-all');

    Route::get('/stroke-incidence-all/export', [StrokeIncidenceAllController::class, 'export'])
        ->name('health.stroke-incidence-all.export');

    Route::get('/dm-incidence-all', [DmIncidenceAllController::class, 'index'])
        ->name('health.dm-incidence-all');

    Route::get('/dm-incidence-all/export', [DmIncidenceAllController::class, 'export'])
        ->name('health.dm-incidence-all.export');

    Route::get('/dm-mortality', [DmMortalityController::class, 'index'])
        ->name('health.dm-mortality');

    Route::get('/dm-mortality/export', [DmMortalityController::class, 'export'])
        ->name('health.dm-mortality.export');

    Route::get('/copd-incidence-all', [CopdIncidenceAllController::class, 'index'])
        ->name('health.copd-incidence-all');

    Route::get('/copd-incidence-all/export', [CopdIncidenceAllController::class, 'export'])
        ->name('health.copd-incidence-all.export');

    Route::get('/copd-mortality', [CopdMortalityController::class, 'index'])
        ->name('health.copd-mortality');

    Route::get('/copd-mortality/export', [CopdMortalityController::class, 'export'])
        ->name('health.copd-mortality.export');

    Route::get('/bc-incidence-all', [BcIncidenceAllController::class, 'index'])
        ->name('health.bc-incidence-all');

    Route::get('/bc-incidence-all/export', [BcIncidenceAllController::class, 'export'])
        ->name('health.bc-incidence-all.export');

    Route::get('/cc-incidence-all', [CcIncidenceAllController::class, 'index'])
        ->name('health.cc-incidence-all');

    Route::get('/cc-incidence-all/export', [CcIncidenceAllController::class, 'export'])
        ->name('health.cc-incidence-all.export');

    Route::get('/emph-incidence-all', [EmphIncidenceAllController::class, 'index'])
        ->name('health.emph-incidence-all');

    Route::get('/emph-incidence-all/export', [EmphIncidenceAllController::class, 'export'])
        ->name('health.emph-incidence-all.export');

    Route::get('/lc-incidence-all', [LcIncidenceAllController::class, 'index'])
        ->name('health.lc-incidence-all');

    Route::get('/lc-incidence-all/export', [LcIncidenceAllController::class, 'export'])
        ->name('health.lc-incidence-all.export');
});

/*
|--------------------------------------------------------------------------
| Death Dashboard / Death Summary Manage
|--------------------------------------------------------------------------
*/

Route::prefix('health')->group(function () {
    Route::get('/death-dashboard', [DeathDashboardController::class, 'index'])
        ->name('health.death_dashboard');

    Route::get('/death-dashboard/export', [DeathDashboardController::class, 'export'])
        ->name('health.death_dashboard.export');
});

Route::prefix('death-summary-manage')->group(function () {
    Route::get('/', [DeathSummaryManageController::class, 'index'])
        ->name('death_summary.manage');

    Route::post('/import', [DeathSummaryManageController::class, 'import'])
        ->name('death_summary.import');

    Route::post('/store', [DeathSummaryManageController::class, 'store'])
        ->name('death_summary.store');

    Route::put('/{id}', [DeathSummaryManageController::class, 'update'])
        ->name('death_summary.update');

    Route::delete('/{id}', [DeathSummaryManageController::class, 'destroy'])
        ->name('death_summary.destroy');
});

Route::get('/death-summary/template', [DeathSummaryManageController::class, 'downloadTemplate'])
    ->name('death_summary.template');

Route::post('/death-summary/bulk-destroy', [DeathSummaryManageController::class, 'bulkDestroy'])
    ->name('death_summary.bulk_destroy');

/*
|--------------------------------------------------------------------------
| Education
|--------------------------------------------------------------------------
*/

Route::prefix('education')->group(function () {
    Route::get('/', [EducationDashboardController::class, 'index'])
        ->name('education.dashboard');

    Route::get('/export', [EducationDashboardController::class, 'export'])
        ->name('education.export');
});

/*
|--------------------------------------------------------------------------
| Economy
|--------------------------------------------------------------------------
*/

Route::prefix('economy')->group(function () {
    Route::get('/', [EconomyController::class, 'index'])
        ->name('economy.index');

    Route::get('/export', [EconomyController::class, 'export'])
        ->name('economy.export');
});

/*
|--------------------------------------------------------------------------
| Forest Resources
|--------------------------------------------------------------------------
*/

Route::prefix('forest-resources')->group(function () {
    Route::get('/', [ForestResourceController::class, 'index'])
        ->name('forest.resources.index');

    Route::get('/manage', [ForestResourceController::class, 'manage'])
        ->name('forest.resources.manage');

    Route::post('/store', [ForestResourceController::class, 'store'])
        ->name('forest.resources.store');

    Route::post('/import', [ForestResourceController::class, 'import'])
        ->name('forest.resources.import');

    Route::put('/{id}', [ForestResourceController::class, 'update'])
        ->name('forest.resources.update');

    Route::delete('/{id}', [ForestResourceController::class, 'destroy'])
        ->name('forest.resources.destroy');

    Route::post('/bulk-destroy', [ForestResourceController::class, 'bulkDestroy'])
        ->name('forest.resources.bulk_destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Users
|--------------------------------------------------------------------------
*/

Route::prefix('admin/users')->group(function () {
    Route::get('/', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/{id}/approve', [AdminUserController::class, 'approve'])
        ->name('admin.users.approve');

    Route::post('/{id}/pending', [AdminUserController::class, 'pending'])
        ->name('admin.users.pending');

    Route::get('/{id}/edit', [AdminUserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/{id}/update', [AdminUserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/{id}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.destroy');
});
Route::middleware(['admin'])->prefix('system-logs')->group(function () {

    Route::get('/',
        [SystemLogController::class, 'index'])
        ->name('system.logs.index');

});
Route::middleware(['admin'])->get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
    Route::middleware(['admin'])->get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
});
 Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::post('/profile/update', [ProfileController::class, 'update'])
    ->name('profile.update');