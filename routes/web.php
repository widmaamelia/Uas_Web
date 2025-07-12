<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmeliaBookController;
use App\Http\Controllers\AmeliaCategoryController;
use App\Http\Controllers\AmeliaMemberController;
use App\Http\Controllers\AmeliaBorrowingController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\AmeliaBook;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman Utama (Publik)
Route::get('/', function () {
    $books = AmeliaBook::all();
    return view('home', compact('books'));
});

// 📘 Daftar Buku (Publik)
Route::get('/books', [AmeliaBookController::class, 'index'])->name('books.index');

// ➕ Tambah Buku (Form Create) - Harus di atas show
Route::get('/books/create', [AmeliaBookController::class, 'create'])
    ->name('books.create')
    ->middleware('auth');

// 📖 Detail Buku (Publik)
Route::get('/books/{ameliaBook}', [AmeliaBookController::class, 'show'])->name('books.show');

// 🏡 Halaman Home Setelah Login
Route::get('/home', [AmeliaBookController::class, 'home'])->name('home');

// ==============================
// ✏️ CRUD Resource Routes (Admin)
// ==============================
Route::middleware('auth')->group(function () {

    // 📚 Buku
    Route::resource('books', AmeliaBookController::class)
        ->except(['index', 'show', 'create'])
        ->parameters(['books' => 'ameliaBook']);

    // 🏷️ Kategori
    Route::resource('categories', AmeliaCategoryController::class)
        ->parameters(['categories' => 'ameliaCategory']);

    // 👥 Anggota
    Route::resource('members', AmeliaMemberController::class)
        ->parameters(['members' => 'ameliaMember']);

    // 🔄 Peminjaman
    Route::resource('borrowings', AmeliaBorrowingController::class)
        ->parameters(['borrowings' => 'ameliaBorrowing']);
          // Tambahan manual
    Route::patch('borrowings/{id}/return', [AmeliaBorrowingController::class, 'returnBook'])
        ->name('borrowings.return');

    Route::patch('borrowings/{id}/verify', [AmeliaBorrowingController::class, 'verify'])
        ->name('borrowings.verify');
});

// ===========================
// 🔐 Login Admin (Manual Auth)
// ===========================

// Halaman Login Admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('auth.login');

// Proses Login Admin
Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');

// Alias untuk @guest/@auth
Route::get('/login', fn () => redirect()->route('auth.login'))->name('login');

// Proses Logout Admin
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');


// ==================================
// 📌 Tambahan khusus untuk user biasa
// ==================================

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Form pinjam dari user frontend (untuk yang sudah login)
Route::post('/peminjaman', [\App\Http\Controllers\AmeliaBorrowingController::class, 'store'])
    ->name('peminjaman.store')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/pinjamanku', [AmeliaBorrowingController::class, 'myBorrowings'])->name('user.borrowings');
    Route::post('/pinjamanku/kembalikan/{id}', [AmeliaBorrowingController::class, 'returnBook'])->name('borrowings.return');
});
// Route untuk pengembalian buku
