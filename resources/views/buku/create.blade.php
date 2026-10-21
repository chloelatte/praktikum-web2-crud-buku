@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h3 class="page-title mb-3">Tambah Buku</h3>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('buku.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" maxlength="100"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}">
                    @error('judul')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" maxlength="30"
                           class="input-nama form-control @error('penulis') is-invalid @enderror"
                           value="{{ old('penulis') }}">
                    <div class="hint-live text-danger small mt-1" style="display:none"></div>
                    @error('penulis')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga">Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                        <input type="text" id="harga" name="harga" inputmode="numeric" placeholder="contoh: 85.000"
                               class="rupiah form-control @error('harga') is-invalid @enderror"
                               value="{{ old('harga') }}">
                    </div>
                    <div class="hint-live text-danger small mt-1" style="display:none"></div>
                    @error('harga')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tgl_terbit">Tanggal Terbit</label>
                    <input type="text" id="tgl_terbit" name="tgl_terbit" readonly autocomplete="off"
                           placeholder="yyyy-mm-dd (pilih dari kalender)" style="background-color:#fff"
                           class="date form-control @error('tgl_terbit') is-invalid @enderror"
                           value="{{ old('tgl_terbit') }}">
                    @error('tgl_terbit')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection