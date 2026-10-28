@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('page-heading', 'Tambah Buku')

@section('content')

    <!-- Judul Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                Tambah Buku
            </h1>
            <p class="mb-0 text-gray-600">
                Tambahkan koleksi baru ke perpustakaan.
            </p>
        </div>

        <a href="{{ route('buku.index') }}"
           class="btn btn-secondary btn-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Daftar Buku
        </a>
    </div>

    <!-- Form Tambah Buku -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-book-medical mr-2"></i>
                        Formulir Data Buku
                    </h6>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>
                                Periksa kembali data yang kamu masukkan.
                            </strong>

                            <ul class="mb-0 mt-2 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf

                        <!-- Judul Buku -->
                        <div class="form-group">
                            <label for="judul" class="font-weight-bold">
                                Judul Buku
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                maxlength="100"
                                required
                                class="form-control @error('judul') is-invalid @enderror"
                                placeholder="Masukkan judul buku"
                                value="{{ old('judul') }}"
                            >

                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="form-group">
                            <label for="penulis" class="font-weight-bold">
                                Penulis
                            </label>

                            <input
                                type="text"
                                id="penulis"
                                name="penulis"
                                maxlength="30"
                                required
                                class="input-nama form-control @error('penulis') is-invalid @enderror"
                                placeholder="Masukkan nama penulis"
                                value="{{ old('penulis') }}"
                            >

                            <div class="hint-live text-danger small mt-1"
                                 style="display:none"></div>

                            @error('penulis')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Harga Buku -->
                        <div class="form-group">
                            <label for="harga" class="font-weight-bold">
                                Harga Buku
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>

                                <input
                                    type="text"
                                    id="harga"
                                    name="harga"
                                    inputmode="numeric"
                                    required
                                    placeholder="Contoh: 85.000"
                                    class="rupiah form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga') }}"
                                >
                            </div>

                            <div class="hint-live text-danger small mt-1"
                                 style="display:none"></div>

                            @error('harga')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tanggal Terbit -->
                        <div class="form-group">
                            <label for="tgl_terbit" class="font-weight-bold">
                                Tanggal Terbit
                            </label>

                            <input
                                type="text"
                                id="tgl_terbit"
                                name="tgl_terbit"
                                readonly
                                autocomplete="off"
                                required
                                placeholder="Pilih tanggal terbit"
                                class="date form-control @error('tgl_terbit') is-invalid @enderror"
                                value="{{ old('tgl_terbit') }}"
                            >

                            <small class="form-text text-muted">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Pilih tanggal melalui kalender.
                            </small>

                            @error('tgl_terbit')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-end flex-wrap">
                            <a href="{{ route('buku.index') }}"
                               class="btn btn-light border mr-2 mb-2">
                                <i class="fas fa-times mr-1"></i>
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-primary mb-2">
                                <i class="fas fa-save mr-1"></i>
                                Simpan Buku
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection