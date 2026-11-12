@extends('layouts.app')

@section('title', 'Hasil Pencarian Buku')

@section('page-heading', 'Hasil Pencarian Buku')

@section('content')

    <!-- Header Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                Hasil Pencarian Buku
            </h1>
            <p class="mb-0 text-gray-600">
                Temukan koleksi berdasarkan judul atau nama penulis.
            </p>
        </div>

        <a href="{{ route('buku.index') }}"
           class="btn btn-secondary btn-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Daftar Buku
        </a>
    </div>

    <!-- Form Pencarian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-search mr-2"></i>
                Cari Buku
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('buku.search') }}" method="GET">
                <label for="kata" class="font-weight-bold">
                    Kata Kunci
                </label>

                <div class="input-group">
                    <input
                        type="text"
                        id="kata"
                        name="kata"
                        class="form-control"
                        placeholder="Masukkan judul atau nama penulis..."
                        value="{{ $cari }}"
                        aria-label="Kata kunci pencarian"
                    >

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hasil Pencarian -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Hasil
            </h6>

            <small class="text-muted">
                Kata kunci:
                <strong>{{ $cari !== '' ? $cari : '(kosong)' }}</strong>
            </small>
        </div>

        @if (count($data_buku))

            <div class="card-body border-bottom">
                <div class="alert alert-success mb-0" role="status">
                    <i class="fas fa-check-circle mr-1"></i>
                    Ditemukan <strong>{{ $jumlah_buku }}</strong> buku
                    yang sesuai dengan kata kunci
                    <strong>{{ $cari }}</strong>.
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 65px;">
                                No.
                            </th>
                            <th class="text-center">Cover</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Tanggal Terbit</th>
                            <th class="text-center" style="min-width: 150px;">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_buku as $buku)
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
                                    <a
                                        href="{{ route('buku.edit', $buku->id) }}"
                                        class="btn btn-sm btn-warning mb-1"
                                    >
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('buku.destroy', $buku->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin hapus data ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger mb-1">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    Total hasil: {{ $jumlah_buku }} buku
                </small>

                {{ $data_buku->links() }}
            </div>

        @else

            <div class="card-body text-center py-5">
                <i class="fas fa-book-open fa-3x text-gray-300 mb-3"></i>

                <h5 class="font-weight-bold text-gray-800">
                    Buku Tidak Ditemukan
                </h5>

                <p class="text-muted">
                    Tidak ada buku yang cocok dengan kata kunci
                    <strong>{{ $cari }}</strong>.
                    Coba gunakan kata kunci lain.
                </p>

                <a href="{{ route('buku.index') }}"
                   class="btn btn-primary">
                    <i class="fas fa-list mr-1"></i>
                    Lihat Semua Buku
                </a>
            </div>

        @endif

    </div>

@endsection
