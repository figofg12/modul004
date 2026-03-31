<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // TAMPIL LOGIN
    public function showLogin() {
        return view('auth.login');
    }

    // TAMPIL REGISTER
    public function showRegister() {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    // PROSES LOGIN
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('books.index');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // LOGOUT
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}