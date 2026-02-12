<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $siswas = Siswa::orderBy('nama')->get();
        return view('auth.login', compact('siswas'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');

        // First check siswa table by username, then fallback to nis
        $siswa = Siswa::where('username', $identifier)->orWhere('nis', $identifier)->first();
        if ($siswa && isset($siswa->password) && password_verify($password, $siswa->password)) {
            // login as siswa via session
            session()->put('siswa_id', $siswa->id);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Login siswa berhasil.');
        }

        // then try admin via default Auth (username/email)
        if (Auth::attempt(['name' => $identifier, 'password' => $password]) || Auth::attempt(['email' => $identifier, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['identifier' => 'Nama pengguna atau kata sandi salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        // logout admin jika ada
        if (Auth::check()) {
            Auth::logout();
        }

        // hapus session siswa bila login sebagai siswa
        session()->forget('siswa_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}