@extends('layouts.app')

@section('title', 'Halaman Post')

@section('page-heading', 'Halaman Post')

@section('content')
<div class="d-flex align-items-center mb-4">
    <img src="{{ asset('images/book-logo.svg') }}"
         alt="Logo Perpustakaan"
         style="width: 58px; height: 58px; margin-right: 16px;">

    <div>
        <h2 class="font-weight-bold mb-1">Halaman Post</h2>
        <p class="text-muted mb-0">
            Informasi halaman yang ditampilkan melalui PostController.
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="font-weight-bold mb-3">Selamat Datang</h5>

        <p class="text-muted mb-4">
            Ini adalah halaman yang ditampilkan melalui PostController.
            Halaman ini menggunakan layout utama agar tampilannya konsisten
            dengan halaman lain dalam aplikasi Perpustakaan.
        </p>

        <a href="{{ route('buku.index') }}" class="btn btn-primary">
            Kembali ke Daftar Buku
        </a>
    </div>
</div>
@endsection