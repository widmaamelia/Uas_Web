@extends('layout.app')

@section('content')
<h1>Tambah Anggota</h1>

<form action="{{ route('members.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jurusan</label>
        <input type="text" name="jurusan" class="form-control" required>
    </div>
    <button class="btn btn-success">Simpan</button>
</form>
@endsection
