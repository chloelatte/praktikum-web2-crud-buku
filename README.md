# Praktikum Pemrograman Web 2 - Bab VI: Fitur Pelengkap CRUD

Aplikasi CRUD data buku dengan Laravel 13. Fitur: format harga dan tanggal Indonesia,
datepicker, pagination, flash message, validasi input (Bahasa Indonesia), dan pencarian.

## Cara menjalankan

1. `composer install`
2. `copy .env.example .env` lalu `php artisan key:generate`
3. `php artisan migrate`
4. `php artisan db:seed --class=BukuSeeder`
5. `php artisan serve`, lalu buka `http://127.0.0.1:8000/buku`
