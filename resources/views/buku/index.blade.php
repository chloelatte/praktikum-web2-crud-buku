@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

    {{-- Header halaman --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="font-weight-bold mb-1">Data Buku</h2>
            <p class="text-muted mb-0">
                Kelola koleksi buku perpustakaan dengan mudah.
            </p>
        </div>

        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            + Tambah Buku
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (Session::has('pesan'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('pesan') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Ringkasan jumlah buku --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img
                    src="{{ asset('images/book-logo.svg') }}"
                    alt="Logo koleksi buku"
                    style="width: 58px; height: 58px; margin-right: 16px;"
                >

                <div>
                    <p class="text-muted mb-1">Total Koleksi Buku</p>
                    <h3 class="font-weight-bold mb-0">{{ $jumlah_buku }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel data buku --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="font-weight-bold mb-2 mb-md-0">Daftar Koleksi</h5>

                <form action="{{ route('buku.search') }}" method="get"
                      class="form-inline">
                    <input
                        type="text"
                        name="kata"
                        class="form-control mr-2 mb-2 mb-sm-0"
                        placeholder="Cari judul atau penulis..."
                        value="{{ request('kata') }}"
                        aria-label="Cari judul atau penulis"
                    >

                    <button type="submit" class="btn btn-outline-primary">
                        Cari
                    </button>

                    @if (request()->filled('kata'))
                        <a href="{{ route('buku.index') }}"
                           class="btn btn-link">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 65px;">No.</th>
                            <th class="text-center">Cover</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Tanggal Terbit</th>
                            <th class="text-center" style="min-width: 145px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_buku as $buku)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ ++$no }}
                                </td>

                                {{-- Cover Buku --}}
                                <td class="text-center align-middle">
                                    @if ($buku->cover)
                                        <img
                                            src="{{ asset('storage/' . $buku->cover) }}"
                                            alt="Cover {{ $buku->judul }}"
                                            style="width: 55px; height: 75px; object-fit: cover;"
                                            class="img-thumbnail"
                                        >
                                    @else
                                        <span class="text-muted small">
                                            Tidak ada cover
                                        </span>
                                    @endif
                                </td>

                                <td class="align-middle font-weight-bold">
                                    {{ $buku->judul }}
                                </td>

                                <td class="align-middle">
                                    {{ $buku->penulis }}
                                </td>

                                <td class="text-right align-middle text-nowrap">
                                    Rp {{ number_format($buku->harga, 0, ',', '.') }}
                                </td>

                                <td class="text-center align-middle text-nowrap">
                                    {{ $buku->tgl_terbit->format('d/m/Y') }}
                                </td>

                                <td class="text-center align-middle text-nowrap">
                                    <a href="{{ route('buku.edit', $buku->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('buku.destroy', $buku->id) }}"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin hapus data ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <h6 class="font-weight-bold">Belum ada data buku</h6>
                                    <p class="mb-0">
                                        Tambahkan buku baru untuk mengisi koleksi perpustakaan.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer tabel dan pagination --}}
        <div class="card-footer bg-white">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    Menampilkan {{ $data_buku->count() }} data pada halaman ini
                    dari {{ $jumlah_buku }} buku.
                </small>

                <div>
                    {{ $data_buku->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
