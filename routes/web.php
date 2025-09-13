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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/bukus/search', [BukuController::class, 'search'])->name('bukus.search');
Route::get('/bukuitems/search', [App\Http\Controllers\BukuItemController::class, 'search'])
    ->name('bukuitems.search');

Route::resource('bukus', BukuController::class)->middleware(['auth','verified']);
Route::resource('bukuitems', BukuItemController::class)->middleware(['auth','verified']);
Route::get('/bukus/{id_buku}/items', [BukuItemController::class, 'searchByBuku'])
    ->name('bukuitems.search');

Route::resource('kategoris', KategoriController::class)->middleware(['auth','verified']);
Route::resource('sub_kategoris', SubKategoriController::class)->middleware(['auth','verified']);
Route::resource('raks', RakController::class)->middleware(['auth','verified']);
Route::resource('lokasis', LokasiRakController::class)->middleware(['auth','verified']);
Route::resource('penerbits', PenerbitController::class)->middleware(['auth','verified']);

require __DIR__.'/auth.php';
