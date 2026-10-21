<?php

return [
    'required'        => ':attribute wajib diisi.',
    'string'          => ':attribute harus berupa teks.',
    'integer'         => ':attribute harus berupa angka bulat.',
    'numeric'         => ':attribute harus berupa angka.',
    'date'            => ':attribute harus berupa tanggal yang valid.',
    'date_format'     => ':attribute harus berformat :format.',
    'before_or_equal' => ':attribute tidak boleh melebihi :date.',
    'regex'           => 'Format :attribute tidak valid.',
    'unique'          => ':attribute sudah ada.',

    'min' => [
        'numeric' => ':attribute minimal :min.',
        'string'  => ':attribute minimal :min karakter.',
    ],
    'max' => [
        'numeric' => ':attribute maksimal :max.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
    ],

    // Pesan khusus per kolom (lebih jelas bagi pengguna)
    'custom' => [
        'judul' => [
            'unique' => 'Judul buku ini sudah terdaftar.',
        ],
        'penulis' => [
            'regex' => 'Penulis hanya boleh berisi huruf, spasi, titik, koma, apostrof, dan tanda hubung (tidak boleh angka).',
        ],
        'harga' => [
            'integer' => 'Harga harus berupa angka bulat tanpa huruf atau simbol, contoh: 85.000.',
            'min'     => 'Harga minimal Rp 1.000.',
            'max'     => 'Harga maksimal Rp 100.000.000.',
        ],
        'tgl_terbit' => [
            'date_format'     => 'Tanggal terbit harus berformat yyyy-mm-dd (pilih dari kalender).',
            'before_or_equal' => 'Tanggal terbit tidak boleh lebih dari hari ini.',
        ],
    ],

    'attributes' => [
        'judul'      => 'Judul',
        'penulis'    => 'Penulis',
        'harga'      => 'Harga',
        'tgl_terbit' => 'Tanggal terbit',
    ],
];