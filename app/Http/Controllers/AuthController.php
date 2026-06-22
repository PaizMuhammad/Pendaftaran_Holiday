<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Perbaikan Route: Pastikan nama route sesuai dengan web.php
            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // Diarahkan ke Dashboard User, bukan form pendaftaran langsung
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    // --- REGISTRASI ---
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            // VALIDASI: Tambahkan 'confirmed' agar password_confirmation wajib sama
            'password' => 'required|min:5|confirmed' 
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' 
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}