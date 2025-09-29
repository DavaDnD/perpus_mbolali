<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\LokasiRakController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Semua role bisa akses dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile → semua role bisa akses
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// 📌 Member (default user)
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/bukus/search', [BukuController::class, 'search'])->name('bukus.search');
    Route::get('/bukuitems/search', [BukuItemController::class, 'search'])->name('bukuitems.search');
    Route::get('/bukus/{id_buku}/items', [BukuItemController::class, 'searchByBuku'])->name('bukuitems.searchByBuku');
    Route::get('/kategoris/{id}/subkategoris', [BukuController::class, 'searchByKategori'])->name('bukus.searchByKategori');
    Route::get('/sub_kategoris/{id}/bukus', [BukuController::class, 'searchBySubKategori'])->name('bukus.searchBySubKategori');
    Route::get('/raks/{id}/bukus', [BukuController::class, 'searchByRak'])->name('bukus.searchByRak');
    Route::get('/penerbits/{id}/bukus', [BukuController::class, 'searchByPenerbit'])->name('bukus.searchByPenerbit');

    // hanya bisa lihat (index + show)
    Route::resource('bukus', BukuController::class)->only(['index','show']);
    Route::resource('bukuitems', BukuItemController::class)->only(['index','show']);
    Route::resource('kategoris', KategoriController::class)->only(['index','show']);
    Route::resource('sub_kategoris', SubKategoriController::class)->only(['index','show']);
    Route::resource('raks', RakController::class)->only(['index','show']);
    Route::resource('lokasis', LokasiRakController::class)->only(['index','show']);
    Route::resource('penerbits', PenerbitController::class)->only(['index','show']);
});

// ==========================
// 📌 Officer + Admin
// ==========================
Route::middleware(['auth','isOfficerOrAdmin'])->group(function () {
// CRUD koleksi
    Route::resource('bukus', BukuController::class)->except(['index','show']);
    Route::resource('bukuitems', BukuItemController::class)->except(['index','show']);
    Route::resource('kategoris', KategoriController::class)->except(['index','show']);
    Route::resource('sub_kategoris', SubKategoriController::class)->except(['index','show']);
    Route::resource('raks', RakController::class)->except(['index','show']);
    Route::resource('lokasis', LokasiRakController::class)->except(['index','show']);
    Route::resource('penerbits', PenerbitController::class)->except(['index','show']);

    // Kelola User (lihat & hapus user)
         Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users'); // Ganti method juga

        Route::delete('/users/destroy-selected', [AdminController::class, 'destroySelected'])->name('users.destroySelected');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');

        Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });
});

// ==========================
// 📌 Admin Only
// ==========================
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

require __DIR__.'/auth.php';
