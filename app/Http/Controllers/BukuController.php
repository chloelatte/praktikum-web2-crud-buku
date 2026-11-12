<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // Menampilkan seluruh data buku
    public function index()
    {
        $batas = 5;
        $jumlah_buku = Buku::count();

        $data_buku = Buku::orderBy('id', 'desc')
            ->paginate($batas);

        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.index', compact(
            'data_buku',
            'no',
            'jumlah_buku'
        ));
    }

    // Mencari buku berdasarkan judul atau penulis
    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;

        $data_buku = Buku::where('judul', 'like', "%{$cari}%")
            ->orWhere('penulis', 'like', "%{$cari}%")
            ->orderBy('id', 'desc')
            ->paginate($batas)
            ->appends(['kata' => $cari]);

        $jumlah_buku = $data_buku->total();
        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.search', compact(
            'jumlah_buku',
            'data_buku',
            'no',
            'cari'
        ));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('buku.create');
    }

    // Menyimpan data buku baru
    public function store(Request $request)
    {
        $validated = $this->validasi($request);

        // Memeriksa apakah pengguna mengunggah cover
        if ($request->hasFile('cover')) {

            // Mengambil nama file asli
            $namaFileAsli = $request->file('cover')
                ->getClientOriginalName();

            // Mengambil nama file tanpa ekstensi
            $namaFile = pathinfo(
                $namaFileAsli,
                PATHINFO_FILENAME
            );

            // Mengambil ekstensi file
            $ekstensi = $request->file('cover')
                ->getClientOriginalExtension();

            // Membuat nama file baru menggunakan timestamp
            $namaFileSimpan = $namaFile . '_' . time() . '.' . $ekstensi;

            // Menyimpan file ke storage/app/public/covers
            $path = $request->file('cover')->storeAs(
                'covers',
                $namaFileSimpan,
                'public'
            );

            // Menyimpan path file ke kolom cover pada database
            $validated['cover'] = $path;
        }

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('pesan', 'Data Buku Berhasil Ditambahkan');
    }

    // Menampilkan form edit buku
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    // Memperbarui data buku
    public function update(Request $request, Buku $buku)
    {
        $validated = $this->validasi($request, $buku);

        // Memeriksa apakah pengguna mengunggah cover baru
        if ($request->hasFile('cover')) {

            // Mengambil nama file asli
            $namaFileAsli = $request->file('cover')
                ->getClientOriginalName();

            // Mengambil nama file tanpa ekstensi
            $namaFile = pathinfo(
                $namaFileAsli,
                PATHINFO_FILENAME
            );

            // Mengambil ekstensi file
            $ekstensi = $request->file('cover')
                ->getClientOriginalExtension();

            // Membuat nama file baru menggunakan timestamp
            $namaFileSimpan = $namaFile . '_' . time() . '.' . $ekstensi;

            // Menyimpan cover baru terlebih dahulu
            $path = $request->file('cover')->storeAs(
                'covers',
                $namaFileSimpan,
                'public'
            );

            // Menyimpan path cover baru ke data yang akan diperbarui
            $validated['cover'] = $path;

            // Menghapus cover lama setelah cover baru berhasil disimpan
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
        }

        // Memperbarui data buku
        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('pesan', 'Data Buku Berhasil di Update');
    }

    // Menghapus data buku
    public function destroy(Buku $buku)
    {
        // Menghapus file cover dari storage jika tersedia
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        // Menghapus data buku dari database
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('pesan', 'Data Buku Berhasil Dihapus');
    }

    // Aturan validasi bersama untuk store dan update
    private function validasi(Request $request, ?Buku $buku = null): array
    {
        // Menghapus format rupiah agar harga dapat divalidasi sebagai angka
        $request->merge([
            'harga' => str_ireplace(
                ['Rp', '.', ' '],
                '',
                (string) $request->harga
            ),
        ]);

        return $request->validate([
            'judul' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('books', 'judul')->ignore($buku?->id),
            ],

            'penulis' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[\pL\pN][\pL\pN\s.,\\\'-]*$/u',
            ],

            'harga' => [
                'bail',
                'required',
                'integer',
                'min:1000',
                'max:100000000',
            ],

            'tgl_terbit' => [
                'bail',
                'required',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],

            // Validasi file cover
            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);
    }
}
