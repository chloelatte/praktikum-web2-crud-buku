<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // Menampilkan detail buku beserta galeri fotonya
    public function show($buku_seo)
    {
        $buku = Buku::where('buku_seo', $buku_seo)->firstOrFail();

        $galeris = $buku->galeris;

        return view('galeri.show', compact('buku', 'galeris'));
    }

    // Menyimpan foto galeri baru
    public function store(Request $request, $buku_seo)
    {
        $buku = Buku::where('buku_seo', $buku_seo)->firstOrFail();

        $validated = $request->validate([
            'nama_galeri' => ['required', 'string', 'min:3', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $path = $request->file('foto')->store('galeri', 'public');

        $buku->galeris()->create([
            'nama_galeri' => $validated['nama_galeri'],
            'keterangan' => $validated['keterangan'] ?? null,
            'foto' => $path,
        ]);

        return redirect()->route('galeri.buku', $buku->buku_seo)
            ->with('pesan', 'Foto Galeri Berhasil Ditambahkan');
    }

    // Menampilkan form edit foto galeri
    public function edit(Galeri $galeri)
    {
        return view('galeri.edit', compact('galeri'));
    }

    // Memperbarui informasi dan foto galeri
    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'nama_galeri' => ['required', 'string', 'min:3', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Jika pengguna mengunggah foto baru
        if ($request->hasFile('foto')) {

            // Simpan foto baru
            $pathBaru = $request->file('foto')->store('galeri', 'public');

            // Hapus foto lama
            if ($galeri->foto) {
                Storage::disk('public')->delete($galeri->foto);
            }

            // Gunakan path foto baru
            $galeri->foto = $pathBaru;
        }

        // Perbarui informasi galeri
        $galeri->nama_galeri = $validated['nama_galeri'];
        $galeri->keterangan = $validated['keterangan'] ?? null;

        $galeri->save();

        return redirect()->route('galeri.buku', $galeri->buku->buku_seo)
            ->with('pesan', 'Foto Galeri Berhasil Diperbarui');
    }

    // Menghapus foto galeri
    public function destroy(Galeri $galeri)
    {
        $bukuSeo = $galeri->buku->buku_seo;

        if ($galeri->foto) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->route('galeri.buku', $bukuSeo)
            ->with('pesan', 'Foto Galeri Berhasil Dihapus');
    }
}
