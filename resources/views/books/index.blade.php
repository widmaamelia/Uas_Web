@extends('layout.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-journal-bookmark-fill text-primary"></i> Manajemen Buku
        </h2>
        <a href="{{ route('books.create') }}" class="btn btn-success shadow-sm rounded-pill">
            <i class="bi bi-plus-lg"></i> Tambah Buku
        </a>
    </div>

    <!-- Empty Message -->
    @if ($books->isEmpty())
        <div class="alert alert-warning text-center">Belum ada data buku.</div>
    @else
    <!-- Card for Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>PDF</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr class="align-middle text-center">
                            <td>
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" class="rounded shadow-sm" width="60" height="80" style="object-fit: cover;" alt="cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-start fw-semibold text-dark">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->year }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $book->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="text-start text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ Str::limit($book->description, 60) }}
                            </td>
                            <td>
                                @if ($book->pdf_file)
                                    <a href="{{ asset('storage/' . $book->pdf_file) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Unduh PDF">
                                        <i class="bi bi-download"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
