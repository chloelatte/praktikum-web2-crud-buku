<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    for ($i = 1; $i <= 10; $i++) {
        Buku::create([
            'judul' => 'Buku ' . $i,
            'penulis' => 'Penulis ' . $i,
            'harga' => 50000 + ($i * 5000),
            'tgl_terbit' => '2026-01-01',
        ]);
    }
}
}