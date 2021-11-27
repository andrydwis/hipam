<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UsageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\UserStaticticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('user-statistic.index');
})->name('root.index');

Route::get('/user-statistic', [UserStaticticController::class, 'index'])->name('user-statistic.index');
Route::post('/user-statistic/search', [UserStaticticController::class, 'search'])->name('user-statistic.search');
Route::get('/user-statistic/{client}', [UserStaticticController::class, 'show'])->name('user-statistic.show');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:superadmin|admin|officer'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('user.show');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('user.destroy');

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create', [ClientController::class, 'create'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.create');
    Route::post('/client/create', [ClientController::class, 'store'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.store');
    Route::get('/client/import', [ClientController::class, 'import'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.import');
    Route::post('/client/import', [ClientController::class, 'importProcess'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.import-process');
    Route::get('/client/export', [ClientController::class, 'export'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.export');
    Route::get('/client/{client}/edit', [ClientController::class, 'edit'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.edit');
    Route::patch('/client/{client}/edit', [ClientController::class, 'update'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.update');
    Route::delete('/client/{client}', [ClientController::class, 'destroy'])->withoutMiddleware('role:superadmin|admin')->middleware('role:superadmin')->name('client.destroy');

    Route::get('/usage', [UsageController::class, 'index'])->name('usage.index');
    Route::get('/usage/all', [UsageController::class, 'showAll'])->name('usage.show-all');
    Route::delete('/usage/{usage}', [UsageController::class, 'destroy'])->name('usage.destroy');
    Route::get('/usage/{client}/{month}/{year}/create', [UsageController::class, 'create'])->name('usage.create');
    Route::post('/usage/{client}/{month}/{year}/create', [UsageController::class, 'store'])->name('usage.store');
    Route::get('/usage/{client}/{month}/{year}/edit', [UsageController::class, 'edit'])->name('usage.edit');
    Route::patch('/usage/{client}/{month}/{year}/edit', [UsageController::class, 'update'])->name('usage.update');
    Route::get('/usage/{month}/{year}', [UsageController::class, 'show'])->name('usage.show');
    Route::get('/usage/{month}/{year}/import', [UsageController::class, 'import'])->name('usage.import');
    Route::post('/usage/{month}/{year}/import', [UsageController::class, 'importProcess'])->name('usage.import-process');
    Route::get('/usage/{month}/{year}/export', [UsageController::class, 'export'])->name('usage.export');

    Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
    Route::get('/bill/all', [BillController::class, 'showAll'])->name('bill.show-all');
    Route::patch('/bill/{bill}/accept-late', [BillController::class, 'acceptLate'])->name('bill.accept-late');
    Route::patch('/bill/{bill}/decline-late', [BillController::class, 'declineLate'])->name('bill.decline-late');
    Route::get('/bill/{month}/{year}', [BillController::class, 'show'])->name('bill.show');
    Route::get('/bill/{month}/{year}/export', [BillController::class, 'export'])->name('bill.export');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/{client}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/transaction/{client}/pay', [TransactionController::class, 'pay'])->name('transaction.pay');
    Route::post('/transaction/{client}/pay-process', [TransactionController::class, 'payProcess'])->name('transaction.pay-process');

    Route::get('/report/income', [ReportController::class, 'income'])->name('report.income');

    // Route::get('/activity-log', [ActivityLogController::class, 'index'])->withoutMiddleware('role:admin')->name('activity-log.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/reset-photo', [ProfileController::class, 'resetPhoto'])->name('profile.reset-photo');
});

Route::view('/test', 'transaction.print');

require __DIR__ . '/auth.php';
