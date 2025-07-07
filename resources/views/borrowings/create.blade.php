@extends('layout.app')

@section('content')
<h2 class="mb-4">Form Peminjaman</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($member && $book)
    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="member_id" value="{{ $member->id }}">
        <input type="hidden" name="book_id" value="{{ $book->id }}">

        <div class="mb-3">
            <label>Nama Buku</label>
            <input type="text" class="form-control" value="{{ $book->title }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama Peminjam</label>
            <input type="text" class="form-control" value="{{ $member->name }}" readonly>
        </div>

        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="borrowed_at" class="form-control" value="{{ now()->toDateString() }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="returned_at" class="form-control" value="{{ now()->addDays(7)->toDateString() }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
@else
    <div class="alert alert-warning">
        Data anggota atau buku tidak ditemukan. Silakan kembali ke halaman utama.
    </div>
@endif

@endsection
