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

    // hanya bisa lihat (index + show)
    Route::resource('bukus', BukuController::class)->only(['index','show']);
    Route::resource('bukuitems', BukuItemController::class)->only(['index','show']);
    Route::resource('kategoris', KategoriController::class)->only(['index','show']);
    Route::resource('sub_kategoris', SubKategoriController::class)->only(['index','show']);
    Route::resource('raks', RakController::class)->only(['index','show']);
    Route::resource('lokasis', LokasiRakController::class)->only(['index','show']);
    Route::resource('penerbits', PenerbitController::class)->only(['index','show']);
});

// 📌 Officer + Admin
Route::middleware(['auth','isOfficerOrAdmin'])->group(function () {
    Route::resource('bukus', BukuController::class)->except(['index','show']);
    Route::resource('bukuitems', BukuItemController::class)->except(['index','show']);
    Route::resource('kategoris', KategoriController::class)->except(['index','show']);
    Route::resource('sub_kategoris', SubKategoriController::class)->except(['index','show']);
    Route::resource('raks', RakController::class)->except(['index','show']);
    Route::resource('lokasis', LokasiRakController::class)->except(['index','show']);
    Route::resource('penerbits', PenerbitController::class)->except(['index','show']);
});

// ==========================
// 📌 Admin Only
// ==========================
Route::middleware(['auth','isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';
