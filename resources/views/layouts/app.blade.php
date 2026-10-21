<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan')</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('buku.index') }}">📚 Perpustakaan</a>
        </div>
    </nav>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    <script>
    // Datepicker (dari modul)
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    // Tampilkan / sembunyikan petunjuk di bawah kolom
    function tampilPetunjuk(el, pesan) {
        var hint = $(el).closest('.form-group').find('.hint-live');
        if (pesan) { hint.text(pesan).show(); } else { hint.hide(); }
    }

    // Kolom penulis: hanya huruf, spasi, titik, koma, apostrof, tanda hubung
    $('.input-nama').on('input', function () {
        var asli   = $(this).val();
        var bersih = asli.replace(/[^\p{L}\s.,'-]/gu, '');
        if (asli !== bersih) {
            $(this).val(bersih);
            tampilPetunjuk(this, 'Penulis hanya boleh berisi huruf (angka dan simbol lain tidak diperbolehkan).');
        } else {
            tampilPetunjuk(this, '');
        }
    });

    // Kolom harga: hanya angka, otomatis berformat 85.000
    $('.rupiah').on('input', function () {
        var asli  = $(this).val();
        var angka = asli.replace(/\D/g, '');
        var ada_terlarang = asli.replace(/[\d.]/g, '') !== '';
        $(this).val(angka ? angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '');
        tampilPetunjuk(this, ada_terlarang ? 'Harga hanya boleh berisi angka.' : '');
    }).trigger('input');
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>