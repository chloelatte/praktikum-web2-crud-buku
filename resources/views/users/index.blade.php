@extends('layouts.app')

@section('title', 'Data Users')

@section('page-heading', 'Data Pengguna')

@section('content')

    <h1 class="h3 mb-1 text-gray-800">Data Pengguna</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Pengguna
            </h6>
        </div>

        <div class="card-body">

            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-3">
                Tambah Pengguna
            </a>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->level }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}"
                                        method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection