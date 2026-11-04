<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


// Login hanya untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout hanya bisa dilakukan oleh pengguna yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman utama
Route::get('/', function () {
    return redirect()->route('buku.index');
});

// Halaman yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/about', [AboutController::class, 'index']);
    Route::get('/post', [PostController::class, 'index']);

    // CRUD buku dan pencarian
    Route::get('/buku', [BukuController::class, 'index'])
        ->name('buku.index');

    Route::get('/buku/search', [BukuController::class, 'search'])
        ->name('buku.search');

    Route::get('/buku/create', [BukuController::class, 'create'])
        ->name('buku.create');

    Route::post('/buku', [BukuController::class, 'store'])
        ->name('buku.store');

    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])
        ->name('buku.edit');

    Route::put('/buku/{buku}', [BukuController::class, 'update'])
        ->name('buku.update');

    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->name('buku.destroy');

    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

    Route::resource('/users', UserController::class)->middleware('admin');
});