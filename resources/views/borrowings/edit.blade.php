@extends('layout.app')

@section('content')
<h1>Edit Peminjaman</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="member_id">Anggota</label>
        <select name="member_id" id="member_id" class="form-control" required>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" {{ $borrowing->member_id == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="book_id">Buku</label>
        <select name="book_id" id="book_id" class="form-control" required>
            @foreach ($books as $book)
                <option value="{{ $book->id }}" {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="borrowed_at">Tanggal Pinjam</label>
        <input
            type="date"
            name="borrowed_at"
            id="borrowed_at"
            class="form-control"
            value="{{ old('borrowed_at', \Carbon\Carbon::parse($borrowing->borrowed_at)->format('Y-m-d')) }}"
            required
        >
    </div>

    <div class="mb-3">
        <label for="returned_at">Tanggal Kembali</label>
        <input
            type="date"
            name="returned_at"
            id="returned_at"
            class="form-control"
            value="{{ old('returned_at', \Carbon\Carbon::parse($borrowing->returned_at)->format('Y-m-d')) }}"
            required
        >
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
