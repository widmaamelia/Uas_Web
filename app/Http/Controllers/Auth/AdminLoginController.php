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
    // public function login(Request $request)
//     {
//         // Validasi input
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required|min:6',
//         ]);

//         $credentials = $request->only('email', 'password');

//         // Coba login
//         if (Auth::attempt($credentials)) {
//             // Regenerasi session
//             $request->session()->regenerate();

//             // Arahkan ke dashboard setelah login
//             return redirect()->route('home');
//  // Ganti sesuai nama route dashboard Anda
//         }

//         // Jika gagal login
//         return back()->withErrors([
//             'email' => 'Email atau password salah.',
//         ])->withInput();
public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    // Coba login
    if (Auth::attempt($credentials)) {
        // Regenerasi session
        $request->session()->regenerate();

        // ✅ Tambahkan pengecekan role
        $user = Auth::user();
        if ($user->role === 'tamu') {
            Auth::logout();
            return redirect()->route('auth.login')->withErrors([
                'email' => 'Akun tamu tidak memiliki akses login.',
            ]);
        }

        // Jika bukan tamu → lanjutkan ke dashboard
        return redirect()->route('home');
    }

    // Jika gagal login
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
