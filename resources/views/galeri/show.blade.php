@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

<style>
    .detail-header {
        margin-bottom: 1.5rem;
    }

    .detail-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .book-cover {
        width: 100%;
        max-width: 180px;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .cover-placeholder {
        width: 180px;
        height: 250px;
        max-width: 100%;
        background: #f3f4f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #858796;
    }

    .book-title {
        color: #343a40;
        font-weight: 700;
        margin-bottom: 1.25rem;
    }

    .book-info {
        color: #6c757d;
        margin-bottom: 0.85rem;
    }

    .book-price {
        color: #4e73df;
        font-size: 1.35rem;
        font-weight: 700;
    }

    .section-heading {
        font-weight: 700;
        color: #343a40;
        margin-bottom: 0.25rem;
    }

    .section-description {
        color: #858796;
        font-size: 0.875rem;
    }

    .section-card-header {
        background: #fff;
        border-bottom: 1px solid #eaecf4;
        padding: 1.25rem 1.5rem;
    }

    .section-card-body {
        padding: 1.5rem;
    }

    .form-label-custom {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }

    .form-control-custom {
        border-radius: 7px;
        border: 1px solid #d1d3e2;
        padding: 0.65rem 0.85rem;
    }

    .form-control-custom:focus {
        border-color: #bac8f5;
        box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.15);
    }

    .gallery-image {
        width: 100%;
        height: 190px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .gallery-image-wrapper {
        overflow: hidden;
        background: #f3f4f6;
    }

    .gallery-image-wrapper:hover .gallery-image {
        transform: scale(1.04);
    }

    .gallery-card {
        border: 1px solid #eaecf4;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        transition: box-shadow 0.2s ease;
    }

    .gallery-card:hover {
        box-shadow: 0 5px 16px rgba(0, 0, 0, 0.09);
    }

    .gallery-empty {
        padding: 3rem 1rem;
        text-align: center;
        color: #858796;
    }

    .gallery-lightbox-link {
        display: block;
        cursor: pointer;
    }

    @media (max-width: 767.98px) {
        .book-cover,
        .cover-placeholder {
            width: 150px;
            height: 210px;
        }

        .section-card-body {
            padding: 1.15rem;
        }

        .gallery-image {
            height: 170px;
        }
    }
</style>

{{-- Header halaman --}}
<div class="detail-header d-flex flex-wrap justify-content-between align-items-center">
    <div class="mb-3 mb-md-0">
        <h2 class="font-weight-bold text-gray-800 mb-1">
            Detail Buku
        </h2>

        <p class="text-muted mb-0">
            Informasi buku dan koleksi foto galeri.
        </p>
    </div>

    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left mr-1"></i>
        Kembali ke Data Buku
    </a>
</div>

{{-- Notifikasi --}}
@if (Session::has('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ Session::get('pesan') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Informasi Buku --}}
<div class="card detail-card mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">

            {{-- Cover Utama --}}
            <div class="col-md-3 text-center mb-4 mb-md-0">
                @if ($buku->cover)
                    <img
                        src="{{ asset('storage/' . $buku->cover) }}"
                        alt="Cover {{ $buku->judul }}"
                        class="book-cover"
                    >
                @else
                    <div class="cover-placeholder mx-auto">
                        <div>
                            <i class="fas fa-book fa-3x mb-2"></i>
                            <p class="mb-0 small">Tidak ada cover</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Detail Buku --}}
            <div class="col-md-9">
                <h3 class="book-title">
                    {{ $buku->judul }}
                </h3>

                <div class="book-info">
                    <i class="fas fa-user-edit mr-2"></i>
                    <strong>Penulis:</strong>
                    {{ $buku->penulis }}
                </div>

                <div class="book-info">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <strong>Tanggal Terbit:</strong>
                    {{ $buku->tgl_terbit->format('d/m/Y') }}
                </div>

                <div class="mt-3">
                    <small class="text-muted d-block mb-1">Harga Buku</small>

                    <div class="book-price">
                        Rp{{ number_format($buku->harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Form Upload Foto Galeri --}}
<div class="card detail-card mb-4">
    <div class="section-card-header">
        <h5 class="section-heading">
            <i class="fas fa-cloud-upload-alt text-primary mr-2"></i>
            Tambah Foto Galeri
        </h5>

        <p class="section-description mb-0">
            Tambahkan foto untuk melengkapi koleksi buku ini.
        </p>
    </div>

    <div class="section-card-body">
        <form
            action="{{ route('galeri.store', $buku->buku_seo) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label for="nama_galeri" class="form-label-custom">
                    Nama Foto
                </label>

                <input
                    type="text"
                    name="nama_galeri"
                    id="nama_galeri"
                    class="form-control form-control-custom @error('nama_galeri') is-invalid @enderror"
                    value="{{ old('nama_galeri') }}"
                    placeholder="Contoh: Tampilan Sampul Belakang"
                >

                @error('nama_galeri')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keterangan" class="form-label-custom">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    rows="3"
                    class="form-control form-control-custom @error('keterangan') is-invalid @enderror"
                    placeholder="Tambahkan deskripsi atau keterangan foto..."
                >{{ old('keterangan') }}</textarea>

                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto" class="form-label-custom">
                    Pilih Foto
                </label>

                <input
                    type="file"
                    name="foto"
                    id="foto"
                    class="form-control-file @error('foto') is-invalid @enderror"
                    accept=".jpg,.jpeg,.png"
                >

                @error('foto')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <small class="form-text text-muted">
                    Format yang diperbolehkan: JPG, JPEG, dan PNG. Maksimal 2 MB.
                </small>
            </div>

            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-upload mr-1"></i>
                Upload Foto
            </button>
        </form>
    </div>
</div>

{{-- Koleksi Foto Galeri --}}
<div class="card detail-card mb-4">
    <div class="section-card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="section-heading">
                <i class="fas fa-images text-primary mr-2"></i>
                Koleksi Galeri
            </h5>

            <p class="section-description mb-0">
                Foto-foto yang tersimpan untuk buku ini.
            </p>
        </div>

        <span class="badge badge-primary px-3 py-2 mt-2 mt-md-0">
            {{ $galeris->count() }} Foto
        </span>
    </div>

    <div class="section-card-body">
        <div class="row">

            @forelse ($galeris as $galeri)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="gallery-card">

                        {{-- Foto dengan Lightbox2 --}}
                        <div class="gallery-image-wrapper">
                            <a
                                href="{{ asset('storage/' . $galeri->foto) }}"
                                data-lightbox="galeri-buku"
                                data-title="{{ $galeri->nama_galeri }}"
                                class="gallery-lightbox-link"
                            >
                                <img
                                    src="{{ asset('storage/' . $galeri->foto) }}"
                                    alt="{{ $galeri->nama_galeri }}"
                                    class="gallery-image"
                                >
                            </a>
                        </div>

                        {{-- Informasi Foto --}}
                        <div class="p-3">
                            <h6 class="font-weight-bold text-gray-800 mb-2">
                                {{ $galeri->nama_galeri }}
                            </h6>

                            <p class="text-muted small mb-3">
                                {{ $galeri->keterangan ?: 'Tidak ada keterangan.' }}
                            </p>

                            {{-- Tombol Edit dan Hapus --}}
                            <div class="d-flex">

                                <a
                                    href="{{ route('galeri.edit', $galeri->id) }}"
                                    class="btn btn-outline-primary btn-sm flex-fill mr-2"
                                >
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>

                                <form
                                    action="{{ route('galeri.destroy', $galeri->id) }}"
                                    method="POST"
                                    class="flex-fill"
                                    onsubmit="return confirm('Yakin ingin menghapus foto ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm btn-block"
                                    >
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="gallery-empty">
                        <i class="fas fa-images fa-3x mb-3"></i>

                        <h6 class="font-weight-bold">
                            Belum Ada Foto Galeri
                        </h6>

                        <p class="mb-0">
                            Upload foto menggunakan formulir di atas untuk menambahkan koleksi galeri buku ini.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
</div>

@endsection
