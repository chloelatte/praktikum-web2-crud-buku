@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('page-heading', 'Tambah Pengguna')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">
        Tambah Pengguna
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Form Tambah Pengguna
            </h6>
        </div>

        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Masukkan nama"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="level">Level</label>
                    <select
                        class="form-control"
                        id="level"
                        name="level"
                        required
                    >
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection