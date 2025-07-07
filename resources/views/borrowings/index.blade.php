@extends('layout.app')

@section('content')
<div class="container py-4">

    <!-- Header & Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-bookmarks-fill text-primary"></i> 📚 Data Peminjaman
        </h2>
        <a href="{{ route('borrowings.create') }}" class="btn btn-success shadow-sm rounded-pill">
            <i class="bi bi-plus-lg"></i> Tambah Peminjaman
        </a>
    </div>

    <!-- Filter Status -->
    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === null ? 'active' : '' }}"
               href="{{ route('borrowings.index') }}">
                Semua <span class="badge bg-light text-dark">{{ $counts['semua'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'belum' ? 'active' : '' }}"
               href="{{ route('borrowings.index', ['status' => 'belum']) }}">
                Sudah Dikembalikan <span class="badge bg-light text-dark">{{ $counts['belum'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'tepat' ? 'active' : '' }}"
               href="{{ route('borrowings.index', ['status' => 'tepat']) }}">
                Tepat Waktu <span class="badge bg-light text-dark">{{ $counts['tepat'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'telat' ? 'active' : '' }}"
               href="{{ route('borrowings.index', ['status' => 'telat']) }}">
                Terlambat <span class="badge bg-light text-dark">{{ $counts['telat'] }}</span>
            </a>
        </li>
    </ul>

    <!-- Tabel -->
    @if ($borrowings->isEmpty())
        <div class="alert alert-warning text-center">Belum ada data peminjaman.</div>
    @else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($borrowings as $borrow)
                            @php
                                $borrowedAt = \Carbon\Carbon::parse($borrow->borrowed_at);
                                $returnedAt = $borrow->returned_at ? \Carbon\Carbon::parse($borrow->returned_at) : null;
                                $dueDate = $borrowedAt->copy()->addDays(7);
                                $today = \Carbon\Carbon::today();
                            @endphp
                            <tr>
                                <td>{{ $borrow->member->name ?? '-' }}</td>
                                <td>{{ $borrow->book->title ?? '-' }}</td>
                                <td>{{ $borrowedAt->translatedFormat('d F Y') }}</td>
                                <td>
                                    {{ $returnedAt ? $returnedAt->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($borrow->status === 'diproses')
                                        <span class="badge bg-info text-dark">Diproses</span>
                                    @elseif ($returnedAt)
                                        @if ($returnedAt->gt($dueDate))
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @endif
                                    @else
                                        @if ($today->gt($dueDate))
                                            <span class="badge bg-danger">Belum Dikembalikan (Terlambat)</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Dikembalikan</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (auth()->user()->role === 'admin' && $borrow->status === 'diproses')
                                        <form action="{{ route('borrowings.verify', $borrow->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill mb-1">
                                                <i class="bi bi-check2-circle"></i> Verifikasi
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('borrowings.edit', $borrow->id) }}"
                                       class="btn btn-sm btn-warning rounded-pill mb-1">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>

                                    @if (!$borrow->returned_at)
                                    <form action="{{ route('borrowings.return', $borrow->id) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success rounded-pill mb-1">
                                            <i class="bi bi-check-circle"></i> Kembalikan
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('borrowings.destroy', $borrow->id) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-pill">
                                            <i class="bi bi-trash-fill"></i> Hapus
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
