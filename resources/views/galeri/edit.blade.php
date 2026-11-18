@extends('layouts.app')

@section('title', 'Edit Foto Galeri')

@section('content')

<style>
    .edit-header {
        margin-bottom: 1.5rem;
    }

    .edit-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .edit-card-header {
        background: #fff;
        border-bottom: 1px solid #eaecf4;
        padding: 1.25rem 1.5rem;
    }

    .edit-card-body {
        padding: 1.5rem;
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

    .current-image {
        width: 100%;
        max-width: 320px;
        max-height: 280px;
        object-fit: contain;
        border-radius: 10px;
        border: 1px solid #eaecf4;
        background: #f8f9fc;
        padding: 5px;
    }

    .image-preview-wrapper {
        background: #f8f9fc;
        border: 1px dashed #d1d3e2;
        border-radius: 10px;
        padding: 1.25rem;
        text-align: center;
    }

    @media (max-width: 767.98px) {
        .edit-card-body {
            padding: 1.15rem;
        }
    }
</style>

{{-- Header halaman --}}
<div class="edit-header d-flex flex-wrap justify-content-between align-items-center">
    <div class="mb-3 mb-md-0">
        <h2 class="font-weight-bold text-gray-800 mb-1">
            Edit Foto Galeri
        </h2>

        <p class="text-muted mb-0">
            Perbarui informasi atau ganti foto galeri buku.
        </p>
    </div>

    <a
        href="{{ route('galeri.buku', $galeri->buku->buku_seo) }}"
        class="btn btn-outline-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Kembali ke Detail Buku
    </a>
</div>

{{-- Form Edit --}}
<div class="card edit-card">
    <div class="edit-card-header">
        <h5 class="section-heading">
            <i class="fas fa-edit text-primary mr-2"></i>
            Formulir Edit Galeri
        </h5>

        <p class="section-description mb-0">
            Ubah nama, keterangan, atau foto yang tersimpan.
        </p>
    </div>

    <div class="edit-card-body">

        <form
            action="{{ route('galeri.update', $galeri->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            {{-- Nama Foto --}}
            <div class="form-group">
                <label for="nama_galeri" class="form-label-custom">
                    Nama Foto
                </label>

                <input
                    type="text"
                    name="nama_galeri"
                    id="nama_galeri"
                    class="form-control form-control-custom @error('nama_galeri') is-invalid @enderror"
                    value="{{ old('nama_galeri', $galeri->nama_galeri) }}"
                    placeholder="Masukkan nama foto"
                >

                @error('nama_galeri')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Keterangan --}}
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
                >{{ old('keterangan', $galeri->keterangan) }}</textarea>

                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Foto Saat Ini --}}
            <div class="form-group">
                <label class="form-label-custom d-block">
                    Foto Saat Ini
                </label>

                <div class="image-preview-wrapper">
                    <img
                        src="{{ asset('storage/' . $galeri->foto) }}"
                        alt="{{ $galeri->nama_galeri }}"
                        class="current-image"
                    >

                    <p class="text-muted small mt-2 mb-0">
                        Foto yang saat ini tersimpan.
                    </p>
                </div>
            </div>

            {{-- Ganti Foto --}}
            <div class="form-group">
                <label for="foto" class="form-label-custom">
                    Ganti Foto
                    <span class="text-muted font-weight-normal">(Opsional)</span>
                </label>

                <input
                    type="file"
                    name="foto"
                    id="foto"
                    class="form-control-file @error('foto') is-invalid @enderror"
                    accept=".jpg,.jpeg,.png"
                >

                @error('foto')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

                <small class="form-text text-muted">
                    Kosongkan jika tidak ingin mengganti foto.
                    Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                </small>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex flex-wrap mt-4">

                <button type="submit" class="btn btn-primary px-4 mr-2 mb-2">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('galeri.buku', $galeri->buku->buku_seo) }}"
                    class="btn btn-outline-secondary px-4 mb-2"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>
</div>

@endsection
