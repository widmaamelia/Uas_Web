<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AmeliaMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        $bookId = $request->book_id;
        return view('auth.register', compact('bookId'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'nim'      => 'required|string|max:50|unique:amelia_members,nim', // ✅ Validasi NIM unik
            'jurusan'  => 'required|string|max:100', // ✅ Validasi jurusan
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        // Simpan ke tabel anggota (amelia_members)
        AmeliaMember::create([
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'nim'     => $request->nim,
            'jurusan' => $request->jurusan,
        ]);

        // Jika ada book_id, redirect ke form peminjaman
        if ($request->filled('book_id')) {
            return redirect()->route('borrowings.create', ['book_id' => $request->book_id]);
        }

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!');
    }
}
