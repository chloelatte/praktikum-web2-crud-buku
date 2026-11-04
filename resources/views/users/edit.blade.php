@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-heading', 'Edit Pengguna')
@section('content')
<h1 class="h3 mb-4 text-gray-800">
    Edit Pengguna
</h1>

<div card="card shadow mb-4">
    <div card="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Form Edit Pengguna
        </h6>
    </div>
    <div card="card-body">
        <!-- Edit form content goes here -->
         <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ $user->name }}"
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
                    value="{{ $user->email }}"
                    required
                >
            </div>

            <div class="form-group">
                <label form="password">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                >
            </div>

            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" id="level" name="level" required>
                    <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->level == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection