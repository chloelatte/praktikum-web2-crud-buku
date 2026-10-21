<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [AboutController::class, 'index']);
Route::get('/post', [PostController::class, 'index']);
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);