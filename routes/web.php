<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\UsageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\ProfileController;
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
    return view('welcome');
})->name('root.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client/create', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/import', [ClientController::class, 'import'])->name('client.import');
    Route::post('/client/import', [ClientController::class, 'importProcess'])->name('client.import-process');
    Route::get('/client/export', [ClientController::class, 'export'])->name('client.export');
    Route::get('/client/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::patch('/client/{client}/edit', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{client}', [ClientController::class, 'destroy'])->name('client.destroy');

    Route::get('/usage', [UsageController::class, 'index'])->name('usage.index');
    Route::get('/usage/{client}/{month}/{year}/create', [UsageController::class, 'create'])->name('usage.create');
    Route::post('/usage/{client}/{month}/{year}/create', [UsageController::class, 'store'])->name('usage.store');
    Route::get('/usage/{client}/{month}/{year}/edit', [UsageController::class, 'edit'])->name('usage.edit');
    Route::patch('/usage/{client}/{month}/{year}/edit', [UsageController::class, 'update'])->name('usage.update');
    Route::get('/usage/{month}/{year}', [UsageController::class, 'show'])->name('usage.show');
    Route::get('/usage/{month}/{year}/export', [UsageController::class, 'export'])->name('usage.export');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/reset-photo', [ProfileController::class, 'resetPhoto'])->name('profile.reset-photo');
});

require __DIR__ . '/auth.php';
