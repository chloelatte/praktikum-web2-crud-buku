<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Perpustakaan')</title>

    <!-- SB Admin 2 -->
    <link rel="stylesheet"
          href="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}">

    <!-- Datepicker yang sudah digunakan proyek -->
    <link rel="stylesheet"
          href="{{ asset('css/bootstrap-datepicker.min.css') }}">

    <style>
        .sidebar-brand-icon img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .content-wrapper {
            min-height: 100vh;
        }

        .card {
            border-radius: 0.5rem;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .form-control {
            border-radius: 0.35rem;
        }

        .page-heading {
            color: #4e73df;
            font-weight: 700;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
            id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
               href="{{ url('/buku') }}">

                <div class="sidebar-brand-icon">
                    <img src="{{ asset('images/book-logo.svg') }}"
                         alt="Logo Perpustakaan">
                </div>

                <div class="sidebar-brand-text mx-2">
                    Perpustakaan
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard / Daftar Buku -->
            <li class="nav-item {{ request()->is('buku') && !request()->is('buku/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/buku') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Menu Lainnya
            </div>

            <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/about') }}">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>About</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('post') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/post') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Post</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Toggle Sidebar -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0"
                        id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div id="content-wrapper" class="d-flex flex-column content-wrapper">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle for Mobile -->
                    <button id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block">
                        <span class="text-gray-600">
                            @yield('page-heading', 'Sistem Informasi Perpustakaan')
                        </span>
                    </div>

                    <ul class="navbar-nav ml-auto">

                        @auth
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-link d-flex align-items-center">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                        Halo, {{ auth()->user()->name }}
                                    </span>

                                    <i class="fas fa-user-circle fa-2x text-gray-400"></i>

                                    <form action="{{ route('logout') }}"
                                          method="POST"
                                          class="ml-3 mb-0">
                                        @csrf

                                        <button type="submit"
                                                class="btn btn-outline-primary btn-sm">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endauth

                    </ul>
                </nav>
                <!-- End Topbar -->

                <!-- Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- End Page Content -->

            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Perpustakaan &copy; {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- End Main Content -->

    </div>

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- SB Admin 2 JavaScript -->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') }}"></script>

    <!-- Datepicker -->
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        // Datepicker
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        // Petunjuk input
        function tampilPetunjuk(el, pesan) {
            var hint = $(el).closest('.form-group').find('.hint-live');

            if (pesan) {
                hint.text(pesan).show();
            } else {
                hint.hide();
            }
        }

        // Validasi karakter penulis
        $('.input-nama').on('input', function () {
            var asli = $(this).val();
            var bersih = asli.replace(/[^\p{L}\p{N}\s.,'-]/gu, '');

            if (asli !== bersih) {
                $(this).val(bersih);

                tampilPetunjuk(
                    this,
                    'Penulis hanya boleh berisi huruf dan tanda baca yang diizinkan.'
                );
            } else {
                tampilPetunjuk(this, '');
            }
        });

        // Format harga dengan pemisah ribuan
        $('.rupiah').on('input', function () {
            var asli = $(this).val();
            var angka = asli.replace(/\D/g, '');
            var adaTerlarang = asli.replace(/[\d.]/g, '') !== '';

            $(this).val(
                angka ? angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : ''
            );

            tampilPetunjuk(
                this,
                adaTerlarang ? 'Harga hanya boleh berisi angka.' : ''
            );
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>

    @stack('scripts')

</body>
</html>
