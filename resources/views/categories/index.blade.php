@extends('layout.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-tags-fill text-primary"></i> Manajemen Kategori
        </h2>
        <a href="{{ route('categories.create') }}" class="btn btn-success shadow-sm rounded-pill">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <!-- Empty Message -->
    @if ($categories->isEmpty())
        <div class="alert alert-warning text-center">Belum ada kategori.</div>
    @else
    <!-- Table Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                        <tr class="align-middle text-center">
                            <td>{{ $categories->firstItem() + $index }}</td>
                            <td class="text-start fw-semibold text-dark">{{ $category->name }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
