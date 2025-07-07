<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Menampilkan form login admin.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file auth/login.blade.php ada
    }

    /**
     * Memproses login admin.
     */
   public function login(Request $request)
{
    // ✅ Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    // ✅ Coba login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // 🚫 Tolak jika role tamu
        if ($user->role === 'tamu') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            abort(403, 'Akun tamu tidak diperbolehkan login.');
        }

        // ✅ Redirect sesuai role
      if ($user->role === 'admin' || $user->role === 'user') {
        return redirect()->route('home'); // Pastikan route ini didefinisikan (sudah ada)
    }
    }

    // ❌ Jika gagal login
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}


    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('auth.login')->with('success', 'Berhasil logout.');
    }
}
