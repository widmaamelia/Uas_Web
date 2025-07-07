@extends('layout.app')

@section('content')
<h1>Edit Kategori</h1>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
