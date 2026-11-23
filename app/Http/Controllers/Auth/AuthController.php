<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ]);
        Auth::login(User::create($data));
        $request->session()->regenerate();
        return to_route('user.dashboard')->with('notice', 'Akun berhasil dibuat! Selamat datang di Plogee 🌱');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        if (!Auth::attempt($credentials + ['is_active' => true])) {
            return back()->withErrors(['email' => 'Periksa email, kata sandi, dan status akunmu.'])
                ->onlyInput('email');
        }
        $request->session()->regenerate();
        return to_route($request->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')
            ->with('notice', 'Selamat datang kembali!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('landing')->with('notice', 'Kamu berhasil keluar dari akun.');
    }
}
