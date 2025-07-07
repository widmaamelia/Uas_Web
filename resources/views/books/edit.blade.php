@extends('layout.app')

@section('content')
<h1>Edit Data Buku</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Ada kesalahan dalam input data:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title">Judul Buku</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required>
        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="author">Penulis</label>
        <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $book->author) }}" required>
        @error('author')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="year">Tahun Terbit</label>
        <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $book->year) }}" required>
        @error('year')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $book->description) }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="category_id">Kategori</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- 📚 Gambar Buku --}}
    <div class="mb-3">
        <label for="image">Gambar Buku</label><br>
        @if ($book->image)
            <img src="{{ asset('storage/' . $book->image) }}" width="80" height="100" class="mb-2" style="object-fit:cover;">
        @else
            <p class="text-muted">Tidak ada gambar</p>
        @endif
        <input type="file" name="image" id="image" class="form-control">
        @error('image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- 📄 File PDF --}}
    <div class="mb-3">
        <label for="pdf_file">File PDF Buku</label><br>
        @if ($book->pdf_file)
            <a href="{{ asset('storage/' . $book->pdf_file) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                <i class="bi bi-file-earmark-pdf-fill"></i> Lihat PDF Lama
            </a><br>
        @else
            <p class="text-muted">Tidak ada file PDF</p>
        @endif
        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf">
        @error('pdf_file')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
