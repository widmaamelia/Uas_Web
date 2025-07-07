@extends('layout.app')

@section('content')

@auth
    @if (auth()->user()->role === 'admin')
        {{-- DASHBOARD ADMIN --}}
        <div class="container py-5">
            <h2 class="mb-4 fw-bold text-center text-primary">📊 Dashboard Admin</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 p-4 bg-gradient bg-primary text-white rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Total Buku</h5>
                                <h2 class="fw-bold">{{ \App\Models\AmeliaBook::count() }}</h2>
                            </div>
                            <i class="bi bi-book-half fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 p-4 bg-gradient bg-success text-white rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Total Anggota</h5>
                                <h2 class="fw-bold">{{ \App\Models\AmeliaMember::count() }}</h2>
                            </div>
                            <i class="bi bi-people fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 p-4 bg-gradient bg-warning text-dark rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Total Peminjaman</h5>
                                <h2 class="fw-bold">{{ \App\Models\AmeliaBorrowing::count() }}</h2>
                            </div>
                            <i class="bi bi-journal-check fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php $isUser = true; @endphp
    @endif
@else
    @php $isUser = true; @endphp
@endauth

@if (isset($isUser))
    {{-- HERO --}}
    @if (!request()->has('category') && !request()->has('search'))
    <section class="vh-100 d-flex align-items-center bg-light bg-gradient position-relative overflow-hidden">
        <div class="container text-center text-md-start">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-3">
                        📚 Selamat Datang di <span class="text-primary">Perpustakaan Digital</span>
                    </h1>
                    <p class="fs-5 text-muted">
                        Jelajahi ribuan buku, dari fiksi hingga edukasi. Pinjam dan baca dengan mudah!
                    </p>
                    <a href="#book-collection" class="btn btn-lg btn-primary mt-3 shadow rounded-pill px-4">
                        🚀 Mulai Jelajah
                    </a>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/1.png') }}" alt="Hero Book" class="img-fluid float-end" style="max-height: 420px;">
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1; background: radial-gradient(circle, #dbeafe, #f9fafb);"></div>
    </section>
    @endif

    {{-- KOLEKSI BUKU --}}
    <div class="container py-5">
        <h2 id="book-collection" class="mb-4 fw-bold text-center text-primary">📚 Koleksi Buku</h2>

        @if (request('category'))
            @php $currentCategory = \App\Models\AmeliaCategory::find(request('category')); @endphp
            @if ($currentCategory)
                <div class="alert alert-info shadow-sm">
                    Kategori: <strong>{{ $currentCategory->name }}</strong>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-dark ms-2">(Tampilkan Semua)</a>
                </div>
            @endif
        @endif

        @if (request('search'))
            <div class="alert alert-info shadow-sm">
                Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-dark ms-2">(Tampilkan Semua)</a>
            </div>
        @endif

        @if ($books->isEmpty())
            <div class="alert alert-warning text-center">Tidak ada buku ditemukan.</div>
        @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach ($books as $book)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 book-card">
                    @if ($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top rounded-top-4" alt="{{ $book->title }}" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-top-4" style="height: 220px;">
                            <i class="bi bi-book fs-1"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-1 text-truncate">{{ \Illuminate\Support\Str::limit($book->title, 40) }}</h6>
                        <small class="text-muted mb-2">{{ $book->author }}</small>

                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill mb-2">
                            Lihat Detail
                        </a>

                        @auth
                            <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}" class="btn btn-sm btn-success w-100 rounded-pill">
                                📖 Pinjam
                            </a>
                        @else
                            <a href="{{ route('register', ['book_id' => $book->id]) }}" class="btn btn-sm btn-warning w-100 rounded-pill">
                                🔐 Daftar untuk Pinjam
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
@endif

@endsection