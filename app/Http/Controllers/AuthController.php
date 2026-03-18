<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = auth()->user()->role;

            return match ($role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'kasir'   => redirect()->route('kasir.dashboard'),
                'kurir'   => redirect()->route('kurir.dashboard'),
                default   => abort(403),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'no_telp'  => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nama'     => $data['nama'],   // 🔥 name → nama
            'email'    => $data['email'],
            'no_telp'  => $data['no_telp'],
            'role'     => 'admin',          // 🔥 WAJIB ADA
            'password' => Hash::make($data['password']),
        ]);

        return redirect('/login')->with('success', 'Register berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        // cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah');
        }

        // update password baru
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
