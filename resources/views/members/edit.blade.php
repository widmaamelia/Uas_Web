@extends('layout.app')

@section('content')
<h1>Edit Anggota</h1>

<form action="{{ route('members.update', $ameliaMember->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" value="{{ $ameliaMember->nim }}" required>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $ameliaMember->name }}" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $ameliaMember->email }}" required>
    </div>
    <div class="mb-3">
        <label>Jurusan</label>
        <input type="text" name="jurusan" class="form-control" value="{{ $ameliaMember->jurusan }}" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
