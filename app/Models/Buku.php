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
        'cover'
    ];
    protected function casts(): array
    {
        return [
            'tgl_terbit' => 'date',
        ];
    }
}