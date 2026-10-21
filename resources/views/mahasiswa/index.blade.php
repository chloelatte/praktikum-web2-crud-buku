<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Profiling Mahasiswa PAD</title>
    <!-- CSS Bootstrap untuk mempercantik tampilan tabel dan form -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container my-5">

    <h2>Daftar Mahasiswa PAD</h2>

    <!-- SOAL 5 & 3: FORM PENCARIAN & FILTER -->
    <form method="GET" action="/mahasiswa" class="row g-3 mb-3">
        <div class="col-md-6">
            <!-- value=" request('search') " menjaga teks tidak hilang setelah klik cari -->
            <input type="text" name="search" class="form-control" placeholder="Cari nama mahasiswa..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="role_1" class="form-select">
                <option value="Semua Peran">Semua Peran</option>
                <!-- Loop menampilkan pilihan role -->
                @foreach($daftar_peran as $role)
                    <!-- Ternary Operator: Menjaga opsi terpilih tidak bergeser -->
                    <option value="{{ $role }}" {{ request('role_1') == $role ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari & Filter</button>
        </div>
    </form>

    <!-- Pengkondisian jika data hasil pencarian kosong -->
    @if($data_mahasiswa->isEmpty())
        <div class="alert alert-warning">Data mahasiswa tidak ditemukan.</div>
    @else
        <!-- TABEL UTAMA MAHASISWA -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Role Utama</th>
                    <th>Role Kedua</th>
                    <th>Skor Keahlian</th>
                </tr>
            </thead>
            <tbody>
                <!-- Blade Foreach untuk looping data dari Controller -->
                @foreach($data_mahasiswa as $index => $mhs)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mhs->user->name }}</td> <!-- Panggil nama dari relasi User -->
                    <td>{{ $mhs->role_1 }}</td>
                    <td>{{ $mhs->role_2 }}</td>
                    <td>{{ $mhs->skill_score }} Poin</td>
                </tr>
                @endforeach
            </tbody>
            <!-- TUGAS PDF: TAMPILKAN TOTAL DI FOOTER TABEL -->
            <tfoot class="table-light">
                <tr>
                    <th colspan="4" class="text-end">Jumlah Data Mahasiswa:</th>
                    <th>{{ $total_mahasiswa }} Orang</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Jumlah Total Skor Keahlian:</th>
                    <th>{{ $total_skor }} Poin</th>
                </tr>
            </tfoot>
        </table>
    @endif

    <!-- SOAL 4: KOTAK STATISTIK SKOR -->
    <div class="card mt-4 p-3 bg-light">
        <h4>Statistik Skor Mahasiswa</h4>
        <div class="row text-center mt-2">
            <div class="col-md-3"><strong>Total Mahasiswa:</strong><br>{{ $total_mahasiswa }} Orang</div>
            <!-- number_format() membatasi desimal 2 angka di belakang koma -->
            <div class="col-md-3"><strong>Rata-Rata Skor:</strong><br>{{ number_format($rata_rata_skor, 2) }} Poin</div>
            <div class="col-md-3"><strong>Skor Tertinggi:</strong><br>{{ $skor_tertinggi }} Poin</div>
            <div class="col-md-3"><strong>Skor Terendah:</strong><br>{{ $skor_terendah }} Poin</div>
        </div>
    </div>

    <!-- SOAL 2: KOTAK 5 MAHASISWA TERBARU -->
    <div class="card mt-4 p-3">
        <h4>5 Mahasiswa Pendaftar Terbaru</h4>
        <ul class="list-group list-group-flush">
            @foreach($mahasiswa_terbaru as $terbaru)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $terbaru->user->name }} ({{ $terbaru->role_1 }})
                    <span class="badge bg-secondary">{{ $terbaru->skill_score }} Poin</span>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>




