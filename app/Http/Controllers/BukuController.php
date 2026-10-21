<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index()
    {
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.index', compact('data_buku', 'no', 'jumlah_buku'));
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%{$cari}%")
            ->orWhere('penulis', 'like', "%{$cari}%")
            ->paginate($batas)
            ->appends(['kata' => $cari]);
        $jumlah_buku = $data_buku->total();
        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.search', compact('jumlah_buku', 'data_buku', 'no', 'cari'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        Buku::create($this->validasi($request));

        return redirect()->route('buku.index')->with('pesan', 'Data Buku Berhasil di Simpan');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $buku->update($this->validasi($request, $buku));

        return redirect()->route('buku.index')->with('pesan', 'Data Buku Berhasil di Update');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('pesan', 'Data Buku Berhasil di Hapus');
    }

    /**
     * Aturan validasi bersama untuk store dan update.
     * $buku diisi saat update agar pengecekan judul unik mengabaikan data itu sendiri.
     */
    private function validasi(Request $request, ?Buku $buku = null): array
    {
        // Buang format rupiah (Rp, titik, spasi) supaya "85.000" dibaca sebagai 85000
        $request->merge([
            'harga' => str_ireplace(['Rp', '.', ' '], '', (string) $request->harga),
        ]);

        return $request->validate([
            'judul' => [
                'bail', 'required', 'string', 'min:3', 'max:100',
                Rule::unique('books', 'judul')->ignore($buku?->id),
            ],
            'penulis' => [
                'bail', 'required', 'string', 'min:3', 'max:30',
                'regex:/^\pL[\pL\s.,\'-]*$/u',
            ],
            'harga' => [
                'bail', 'required', 'integer', 'min:1000', 'max:100000000',
            ],
            'tgl_terbit' => [
                'bail', 'required', 'date', 'date_format:Y-m-d', 'before_or_equal:today',
            ],
        ]);
    }
}