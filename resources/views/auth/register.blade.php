
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | Perpustakaan</title>

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

        .register-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 12px 40px rgba(35, 55, 90, 0.12);
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .btn-register {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <main class="register-card">
        <h1 class="h3 fw-bold mb-2">Buat akun baru</h1>
        <p class="text-secondary mb-4">
            Daftar untuk mulai mengakses perpustakaan.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama lengkap</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    required
                >
                <div class="form-text">Minimal 8 karakter.</div>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">
                    Konfirmasi password
                </label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-register w-100">
                Daftar
            </button>
        </form>

        <p class="text-center text-secondary mt-4 mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-decoration-none">
                Login
            </a>
        </p>
    </main>
</body>
</html>