<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GaleriController;
use App\Mail\SelamatDatangMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\CatatAktivitas;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
use App\Notifications\PesananBerhasil;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Events\PesananDibuat;
use App\Events\PengumumanBaru;

// Login hanya untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
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

    Route::get('/detail-buku/{buku_seo}', [GaleriController::class, 'show'])->name('galeri.buku');
    Route::post('/detail-buku/{buku_seo}/galeri', [GaleriController::class, 'store'])->name('galeri.store');

    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'edit'])
        ->name('galeri.edit');

    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])
        ->name('galeri.update');

    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
});

Route::get('/kirim-email', function () {
    Mail::to('kaori@example.com')->queue(
        new SelamatDatangMail('Kaori')
    );

    return 'Email berhasil dimasukkan ke antrean!';
});

Route::get('/catat-aktivitas', function () {
    CatatAktivitas::dispatch('Kaori');

    return 'Job berhasil dimasukkan ke antrean!';
});

Route::get('/dispatch', function () {
    CatatAktivitas::dispatch('Dispatch');

    return 'Job menggunakan dispatch berhasil dikirim!';
});

Route::get('/dispatch-sync', function () {
    CatatAktivitas::dispatchSync('Dispatch Sync');

    return 'Job menggunakan dispatchSync berhasil dijalankan!';
});

Route::get('/dispatch-after-response', function () {
    CatatAktivitas::dispatchAfterResponse('Dispatch After Response');

    return 'Respons berhasil dikirim!';
});

Route::get('/delay-job', function () {
    CatatAktivitas::dispatch('Delay Job')
        ->delay(now()->addMinute());

    return 'Job berhasil dijadwalkan untuk 1 menit lagi!';
});

Route::get('/high-queue', function () {
    CatatAktivitas::dispatch('High Priority')
        ->onQueue('high');

    return 'Job berhasil dimasukkan ke high queue!';
});

Route::get('/low-queue', function () {
    CatatAktivitas::dispatch('Low Priority')
        ->onQueue('low');

    return 'Job berhasil dimasukkan ke low queue!';
});

Route::get('/batch-aktivitas', function () {
    $batch = Bus::batch([
        new CatatAktivitas('Kaori'),
        new CatatAktivitas('Budi'),
        new CatatAktivitas('Sinta'),
    ])
    ->name('batch-pencatatan-aktivitas')
    ->dispatch();

    return 'Batch berhasil dibuat! Batch ID: ' . $batch->id;
});

Route::get('/batch-success', function () {
    $batch = Bus::batch([
        new CatatAktivitas('Kaori'),
        new CatatAktivitas('Budi'),
        new CatatAktivitas('Sinta'),
    ])
    ->then(function (Batch $batch) {
        logger('Semua Job dalam batch berhasil!');
    })
    ->dispatch();

    return 'Batch berhasil dikirim!';
});

Route::get('/batch-callbacks', function () {
    $batch = Bus::batch([
        new CatatAktivitas('Kaori'),
        new CatatAktivitas('Budi'),
        new CatatAktivitas('Sinta'),
    ])
    ->then(function (Batch $batch) {
        logger('Semua Job berhasil!');
    })
    ->catch(function (Batch $batch, \Throwable $e) {
        logger('Ada Job yang gagal: ' . $e->getMessage());
    })
    ->finally(function (Batch $batch) {
        logger('Batch selesai diproses!');
    })
    ->dispatch();

    return 'Batch dengan callbacks berhasil dikirim!';
});

Route::get('/job-chain', function () {
    Bus::chain([
        new CatatAktivitas('Kaori - Tahap 1'),
        new CatatAktivitas('Kaori - Tahap 2'),
        new CatatAktivitas('Kaori - Tahap 3'),
    ])->dispatch();

    return 'Job Chain berhasil dimasukkan ke antrean!';
});

Route::get('/job-chain-fail', function () {
    Bus::chain([
        new CatatAktivitas('Chain - Tahap 1'),
        new CatatAktivitas('Budi'),
        new CatatAktivitas('Chain - Tahap 3'),
    ])->dispatch();

    return 'Job Chain berhasil dimasukkan ke antrean!';
});

Route::get('/job-chain-success', function () {
    Bus::chain([
        new CatatAktivitas('Kaori - Tahap 1'),
        new CatatAktivitas('Kaori - Tahap 2'),
        new CatatAktivitas('Kaori - Tahap 3'),
        new CatatAktivitas('Chain berhasil diselesaikan'),
    ])->dispatch();

    return 'Job Chain berhasil dikirim!';
});

Route::get('/job-chain-catch', function () {
    Bus::chain([
        new CatatAktivitas('Chain - Tahap 1'),
        new CatatAktivitas('Budi'),
        new CatatAktivitas('Chain - Tahap 3'),
    ])
    ->catch(function (\Throwable $e) {
        logger('Job Chain gagal: ' . $e->getMessage());
    })
    ->dispatch();

    return 'Job Chain berhasil dikirim!';
});

Route::get('/test-overlapping', function () {
    CatatAktivitas::dispatch('Pengujian Overlapping');

    CatatAktivitas::dispatch('Pengujian Overlapping');

    return 'Dua Job berhasil dikirim!';
});

Route::get('/test-rate-limit', function () {
    for ($i = 1; $i <= 5; $i++) {
        CatatAktivitas::dispatch("Rate Limit - Job {$i}");
    }

    return '5 Job berhasil dimasukkan ke antrean!';
});

Route::get('/test-unique-job', function () {
    CatatAktivitas::dispatch('Kaori');
    CatatAktivitas::dispatch('Kaori');
    CatatAktivitas::dispatch('Budi');

    return '3 Job berhasil dikirim!';
});

Route::get('/test-unique-until-processing', function () {
    CatatAktivitas::dispatch('Kaori');

    return 'Job pertama berhasil dikirim!';
});

Route::get('/test-job-exception', function () {
    CatatAktivitas::dispatch('Error');

    return 'Job berhasil dimasukkan ke antrean!';
});


Route::get('/kirim-notifikasi', function () {
    $user = request()->user();

    $user->notify(
        new PesananBerhasil(
            'Kaori',
            'ORD-001',
            250000
        )
    );

    return 'Notification berhasil dimasukkan ke antrean!';
})->middleware('auth');

Route::get('/kirim-event', function () {
    $user = request()->user();

    event(new PesananDibuat(
        $user->id,
        'ORD-002',
        350000
    ));

    return 'Event PesananDibuat berhasil dimasukkan ke antrean!';
})->middleware('auth');

Route::get('/kirim-pengumuman', function () {
    event(new PengumumanBaru(
        'Pemeliharaan Website',
        'Website akan mengalami pemeliharaan pada pukul 22.00 WIB.'
    ));

    return 'Pengumuman berhasil dikirim!';
});