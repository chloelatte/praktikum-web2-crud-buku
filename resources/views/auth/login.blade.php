<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Perpustakaan</title>
    @vite('resources/js/app.js')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8efff, #f8f9fc);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: #fff;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 12px 40px rgba(35, 55, 90, 0.12);
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin-bottom: 28px;
            border-radius: 22px;
            background: #e8eeff;
        }

        .login-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .btn-login {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-google {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            border: 1px solid #ced4da;
            background: #fff;
            color: #333;
        }

        .btn-google:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="brand-icon">
            <img
                src="{{ asset('images/book-logo.svg') }}"
                alt="Logo Perpustakaan"
                class="login-logo"
            >
        </div>

        <h1 class="h3 fw-bold mb-2">Selamat datang!</h1>
        <p class="text-secondary mb-4">
            Login untuk mengakses sistem perpustakaan.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100">
                Login
            </button>
        </form>

        <div class="d-flex align-items-center my-4">
            <hr class="flex-grow-1">
            <span class="px-3 text-secondary small">ATAU</span>
            <hr class="flex-grow-1">
        </div>

        <a href="{{ route('auth.google.redirect') }}"
           class="btn btn-google w-100">
            <img
                src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                alt="Google"
                width="20"
                height="20"
                class="me-2"
            >
            Login dengan Google
        </a>
    </main>
</body>
</html>
