@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

    @if (Session::has('pesan'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('pesan') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h3 class="page-title">Data Buku</h3>

                <div class="d-flex mt-2 mt-md-0">
                    <form action="{{ route('buku.search') }}" method="get" class="form-inline mr-2">
                        <input type="text" name="kata" class="form-control" placeholder="Cari judul / penulis ...">
                        <button class="btn btn-outline-secondary ml-1">Cari</button>
                    </form>
                    <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Tgl. Terbit</th>
                            <th class="col-aksi text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_buku as $buku)
                            <tr>
                                <td class="col-no">{{ ++$no }}</td>
                                <td>{{ $buku->judul }}</td>
                                <td>{{ $buku->penulis }}</td>
                                <td class="text-right">Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                                <td class="col-aksi text-center">
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="post" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                <span class="footer-info">Jumlah Buku: <strong>{{ $jumlah_buku }}</strong></span>
                {{ $data_buku->links() }}
            </div>

        </div>
    </div>

@endsection