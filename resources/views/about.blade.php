@extends('layouts.app')

@section('title', 'About')

@section('content')

    <h2>Halaman About</h2>

    <p>Nama: <?= $nama ?></p>
    <p>Kelas: <?= $kelas ?></p>
    <p>Universitas: <?= $universitas ?></p>

@endsection