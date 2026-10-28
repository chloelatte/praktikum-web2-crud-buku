@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="d-flex align-items-center mb-4">
    <img src="{{ asset('images/book-logo.svg') }}"
         alt="Logo Perpustakaan"
         style="width: 58px; height: 58px; margin-right: 16px;">

    <div>
        <h2 class="font-weight-bold mb-1">Tentang Kami</h2>
        <p class="text-muted mb-0">
            Informasi identitas dan institusi.
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="font-weight-bold mb-4">Informasi Profil</h5>

        <div class="row mb-3">
            <div class="col-md-3 text-muted">Nama</div>
            <div class="col-md-9 font-weight-bold">{{ $nama }}</div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-3 text-muted">Kelas</div>
            <div class="col-md-9 font-weight-bold">{{ $kelas }}</div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-3 text-muted">Universitas</div>
            <div class="col-md-9 font-weight-bold">{{ $universitas }}</div>
        </div>

        <hr>

        <a href="{{ route('buku.index') }}" class="btn btn-primary mt-2">
            Kembali ke Daftar Buku
        </a>
    </div>
</div>
@endsection