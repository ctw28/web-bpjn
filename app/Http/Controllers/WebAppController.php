<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAppController extends Controller
{

    public function setSession(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Kombinasi email dan password tidak valid',
            ], 404);
        }
        $user = Auth::user();
        Auth::login($user);
        $respon_data = [
            'message' => 'Proses login selesai dilakukan',
        ];
        return response()->json($respon_data, 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function session()
    {
        dd(auth()->user());
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function jenisKonten()
    {
        return view('jenis_konten');
    }

    public function grup()
    {
        return view('grup');
    }

    public function pengaturanWeb()
    {
        return view('pengaturan_web');
    }

    public function akun()
    {
        return view('akun');
    }

    public function menu()
    {
        return view('menu');
    }

    public function kontenWeb()
    {
        return view('konten_web');
    }

    public function fileWeb()
    {
        return view('file_web');
    }

    public function verifikasiKonten()
    {
        return view('verifikasi_konten');
    }

    public function verifikasiFile()
    {
        return view('verifikasi_file');
    }

    public function verifikasiKomentar()
    {
        return view('verifikasi_komentar');
    }

    public function login()
    {
        return view('auth');
    }

    public function web()
    {
        return view('website');
    }
}
