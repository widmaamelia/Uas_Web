@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4 p-4">
                <h3 class="mb-4 text-center fw-bold text-primary">
                    ✍️ Formulir Pendaftaran Akun
                </h3>

                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf

                    <input type="hidden" name="book_id" value="{{ $bookId ?? '' }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-pill" placeholder="Masukkan nama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIM</label>
                        <input type="text" name="nim" class="form-control rounded-pill" placeholder="Masukkan NIM" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control rounded-pill" placeholder="Masukkan jurusan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control rounded-pill" placeholder="Masukkan password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill" placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                        🚀 Daftar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
