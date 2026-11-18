<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'judul',
        'penulis',
        'harga',
        'tgl_terbit',
        'cover',
        'buku_seo'
    ];
    protected function casts(): array
    {
        return [
            'tgl_terbit' => 'date',
        ];
    }

    public function galeris(){
        return $this->hasMany(Galeri::class, 'id_buku', 'id');
    }
}