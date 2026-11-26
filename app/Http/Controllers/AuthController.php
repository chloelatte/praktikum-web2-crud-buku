<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('buku.index'));
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password yang kamu masukkan salah.',
            ])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('buku.index');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        $googleUser = Socialite::driver('google')->user();
        $email = $googleUser->getEmail();

        if (!$email || !($googleUser->user['email_verified'] ?? false)) {
            return redirect()->route('login')->withErrors(['email' => 'Email Google tidak tersedia atau belum diverifikasi.',]);
        }

        $user = User::where('google_id', $googleUser->getId())->first();
        if (!$user){
            $user = User::where('email', $email)->first();

            if ($user){
                if ($user->google_id && $user->google_id !== $googleUser->getId()) {
                    return redirect()->route('login')->withErrors(['email' => 'Akun Google tidak dapat dihubungkan dengan akun ini.',]);
                }
                $user->google_id = $googleUser->getId();
                $user->avatar = $googleUser->getAvatar();
                $user->email_verified_at ??=now();
                $user->save();
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'level' => 'user',
                    'email_verified_at' => now(),
                ]);
            }
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended(route('buku.index'));
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}