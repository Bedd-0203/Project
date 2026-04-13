<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role ?? 'guest');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return $this->redirectByRole($user->role ?? 'guest');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    /**
     * Logout (FIXED)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout');
    }

    /**
     * Redirect berdasarkan role
     */
    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'       => redirect()->route('admin.dashboard'),
            'petugas'     => redirect()->route('petugas.dashboard'),
            'masyarakat'  => redirect()->route('masyarakat.dashboard'),
            default       => redirect('/login'),
        };
    }
}