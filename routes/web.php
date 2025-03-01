<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PihakMenghadirkanController;
use App\Http\Controllers\AgendaSaksiPidanaController;
use App\Http\Controllers\AgendaSaksiPerdataController;
use App\Http\Controllers\AgendaBiasaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RiwayatPerkaraController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [WelcomeController::class, "index"])->name('welcome');
Route::post('/saksi-perdata/add', [WelcomeController::class, "createSaksiPerdata"])->name('saksi-perdata.add');;
Route::get('/agenda-saksi-perdata', [AgendaSaksiPerdataController::class, 'index'])->name('agenda-saksi-perdata');
Route::get('/agenda-saksi-pidana', [AgendaSaksiPidanaController::class, 'index'])->name('agenda-saksi-pidana');
Route::get('/agenda-biasa', [AgendaBiasaController::class, 'index'])->name('agenda-biasa');

Route::patch('/agenda-biasa/hadir/{id}', [WelcomeController::class, 'agendaBiasPihakHadir'])->name('agenda-biasa.hadir');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/riwayat-perkara', function () { return view('riwayat-perkara'); })->middleware(['auth', 'verified'])->name('riwayat-perkara');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/perkara', [DashboardController::class, 'createPerkara'])->name('perkara-create');
    Route::delete('/perkara/{id}', [DashboardController::class, 'removePerkara'])->name('perkara.remove');
    Route::get('/perkara/{id}/edit', [DashboardController::class, 'editPerkara'])->name('perkara.edit');
    Route::patch('/perkara/{id}', [DashboardController::class, 'updatePerkara'])->name('perkara.update');
    Route::patch('/perkara/disable/{id}', [DashboardController::class, 'disable'])->name('perkara.disable');

    Route::get('/pihak-menghadirkan', [PihakMenghadirkanController::class, "index"])->name('pihak-menghadirkan');
    Route::post('/pihak-menghadirkan/form', [PihakMenghadirkanController::class, 'add'])->name('pihak-menghadirkan.form');
    Route::delete('/pihak-menghadirkan/{id}', [PihakMenghadirkanController::class, 'destroy'])->name('pihak-menghadirkan.remove');
    Route::patch('/pihak-menghadirkan/{id}', [PihakMenghadirkanController::class, 'update'])->name('pihak-menghadirkan.update');

    // Riwayat Perkara
    Route::get('/riwayat-perkara', [RiwayatPerkaraController::class, 'index'])->name('riwayat-perkara');

    Route::delete('/saksi/{id}', [WelcomeController::class, 'saksiDestroy'])->name('saksi.remove');

});


// Routers For API No Auth
Route::get('/api/v1/perkara', [WelcomeController::class, 'findPerkara']);
Route::get('/api/v1/pihak', [WelcomeController::class, 'findPihak']);

// Routers For API
Route::middleware('auth')->group(function () {
    // Mendapatkan Semua Data Perkara
    // Route::get('/api/v1/perkara', [ProfileController::class, 'edit']);
});



require __DIR__.'/auth.php';
