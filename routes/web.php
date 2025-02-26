<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PihakMenghadirkanController;
use App\Http\Controllers\AgendaSaksiPidanaController;
use App\Http\Controllers\AgendaBiasaController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/agenda-saksi-perdata', [AgendaSaksiPidanaController::class, 'index'])->name('agenda-saksi-perdata');

Route::get('/agenda-biasa', [AgendaBiasaController::class, 'index'])->name('agenda-biasa');




Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/riwayat-perkara', function () {
    return view('riwayat-perkara');
})->middleware(['auth', 'verified'])->name('riwayat-perkara');




// use App\Models\Perkara;






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/perkara', [DashboardController::class, 'createPerkara'])->name('perkara-create');
    Route::delete('/perkara/{id}', [DashboardController::class, 'removePerkara'])->name('perkara.remove');
    Route::get('/perkara/{id}/edit', [DashboardController::class, 'editPerkara'])->name('perkara.edit');
    Route::put('/perkara/{id}', [DashboardController::class, 'updatePerkara'])->name('perkara.update');

    Route::get('/pihak-menghadirkan/form', [PihakMenghadirkanController::class, 'form'])->name('pihak-menghadirkan.form');

    Route::get('/pihak-menghadirkan', [PihakMenghadirkanController::class, "index"])->name('pihak-menghadirkan');
    Route::post('/pihak-menghadirkan/form', [PihakMenghadirkanController::class, 'add'])->name('pihak-menghadirkan.form');
    Route::delete('/pihak-menghadirkan/form', [PihakMenghadirkanController::class, 'destroy'])->name('pihak-menghadirkan.form');


});


// Routers For API
Route::middleware('auth')->group(function () {
    // Mendapatkan Semua Data Perkara
    Route::get('/api/v1/perkara', [ProfileController::class, 'edit']);
});

require __DIR__.'/auth.php';
