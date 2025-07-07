@extends('layout.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">← Kembali ke Beranda</a>

    <div class="card shadow">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" class="img-fluid rounded-start" alt="{{ $book->title }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%; min-height: 300px;">
                        <span class="text-muted">No Image</span>
                    </div>
                @endif
            </div>

            <div class="col-md-8 p-4">
                <h3>{{ $book->title }}</h3>
                <p><strong>Penulis:</strong> {{ $book->author }}</p>
                <p><strong>Tahun:</strong> {{ $book->year }}</p>
                <p><strong>Kategori:</strong> {{ $book->category->name ?? '-' }}</p>
                <p><strong>Deskripsi:</strong> {{ $book->description ?? '-' }}</p>
                <p class="text-muted"><small>Dibuat: {{ $book->created_at->format('d M Y') }}</small></p>

                @if ($book->pdf_file)
                    @auth
                        <a href="{{ asset('storage/' . $book->pdf_file) }}" 
                           class="btn btn-outline-primary mt-3" 
                           target="_blank" 
                           download>
                            <i class="bi bi-download"></i> Unduh PDF Buku
                        </a>
                    @else
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-lock-fill"></i> Anda harus <a href="{{ route('login') }}">login</a> untuk mengunduh file PDF.
                        </div>
                    @endauth
                @else
                    <p class="text-muted mt-3">File PDF tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
