<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeries';

    protected $fillable = [
        'id_buku',
        'nama_galeri',
        'keterangan',
        'foto',
    ];

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id');
    }
}
