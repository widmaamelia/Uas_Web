@extends('layout.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-person-fill text-primary"></i> Manajemen Anggota
        </h2>
        <a href="{{ route('members.create') }}" class="btn btn-success shadow-sm rounded-pill">
            <i class="bi bi-person-plus"></i> Tambah Anggota
        </a>
    </div>

    <!-- Empty Message -->
    @if ($members->isEmpty())
        <div class="alert alert-warning text-center">Belum ada data anggota.</div>
    @else
    <!-- Card for Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jurusan</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $index => $member)
                        <tr class="align-middle text-center">
                            <td>{{ $members->firstItem() + $index }}</td>
                            <td>{{ $member->nim }}</td>
                            <td class="text-start fw-semibold text-dark">{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->jurusan }}</td>
                            <td>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
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

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        <nav>
            <ul class="pagination pagination-sm mb-0">
                {{ $members->onEachSide(1)->links('pagination::bootstrap-5') }}
            </ul>
        </nav>
    </div>
</div>
@endsection
