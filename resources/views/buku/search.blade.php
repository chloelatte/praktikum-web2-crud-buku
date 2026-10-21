@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')

    <div class="card">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h3 class="page-title">Hasil Pencarian</h3>

                <div class="d-flex mt-2 mt-md-0">
                    <form action="{{ route('buku.search') }}" method="get" class="form-inline mr-2">
                        <input type="text" name="kata" class="form-control" placeholder="Cari judul / penulis ..."
                               value="{{ $cari }}">
                        <button class="btn btn-outline-secondary ml-1">Cari</button>
                    </form>
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            @if (count($data_buku))
                <div class="alert alert-success">
                    Ditemukan <strong>{{ $jumlah_buku }}</strong> data dengan kata: <strong>{{ $cari }}</strong>
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
                            @foreach ($data_buku as $buku)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $data_buku->links() }}
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    <h5>Data "{{ $cari }}" tidak ditemukan</h5>
                    <a href="{{ route('buku.index') }}" class="btn btn-warning btn-sm">Kembali</a>
                </div>
            @endif

        </div>
    </div>

@endsection