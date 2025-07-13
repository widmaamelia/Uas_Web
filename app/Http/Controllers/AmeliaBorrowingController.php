<?php

namespace App\Http\Controllers;

use App\Models\AmeliaBorrowing;
use App\Models\AmeliaBook;
use App\Models\AmeliaMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AmeliaBorrowingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $user = Auth::user();

        $query = AmeliaBorrowing::with(['book', 'member.user'])->orderByDesc('created_at');

        if ($user->role !== 'admin') {
            $member = AmeliaMember::where('user_id', $user->id)->first();
            if (!$member) {
                return redirect()->route('home')->with('error', 'Data anggota tidak ditemukan.');
            }
            $query->where('member_id', $member->id);
        }

        $allBorrowings = $query->get();

        $counts = [
            'semua' => $allBorrowings->count(),
            'belum' => $allBorrowings->where('status', 'belum dikembalikan')->count(),
            'tepat' => $allBorrowings->filter(fn($b) =>
                $b->returned_at && Carbon::parse($b->returned_at)->lte(Carbon::parse($b->borrowed_at)->addDays(7))
            )->count(),
            'telat' => $allBorrowings->filter(fn($b) =>
                $b->returned_at && Carbon::parse($b->returned_at)->gt(Carbon::parse($b->borrowed_at)->addDays(7))
            )->count(),
        ];

        // Apply status filter
        $query = AmeliaBorrowing::with(['book', 'member.user'])->orderByDesc('created_at');
        if ($user->role !== 'admin') {
            $member = AmeliaMember::where('user_id', $user->id)->first();
            $query->where('member_id', $member->id);
        }

        match ($status) {
            'belum' => $query->where('status', 'belum dikembalikan'),
            'tepat' => $query->whereNotNull('returned_at')->whereRaw('DATE(returned_at) <= DATE_ADD(borrowed_at, INTERVAL 7 DAY)'),
            'telat' => $query->whereNotNull('returned_at')->whereRaw('DATE(returned_at) > DATE_ADD(borrowed_at, INTERVAL 7 DAY)'),
            default => null,
        };

        $borrowings = $query->paginate(10)->withQueryString();

        return view('borrowings.index', [
            'borrowings' => $borrowings,
            'counts' => $counts,
            'activeStatus' => $status,
        ]);
    }

    public function create(Request $request)
    {
        $books = AmeliaBook::all();
        $selectedBookId = $request->book_id;
        $book = $selectedBookId ? AmeliaBook::find($selectedBookId) : null;
        $member = AmeliaMember::where('user_id', Auth::id())->first();

        return view('borrowings.create', compact('books', 'book', 'member'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            $request->validate([
                'member_id'   => 'required|exists:amelia_members,id',
                'book_id'     => 'required|exists:amelia_books,id',
                'borrowed_at' => 'required|date',
                'returned_at' => 'required|date|after_or_equal:borrowed_at',
            ]);

            AmeliaBorrowing::create($request->only('member_id', 'book_id', 'borrowed_at', 'returned_at') + ['status' => 'belum dikembalikan']);

            return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil disimpan.');
        }

        $request->validate([
            'book_id' => 'required|exists:amelia_books,id',
        ]);

        $member = AmeliaMember::where('user_id', Auth::id())->first();
        if (!$member) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        AmeliaBorrowing::create([
            'member_id'   => $member->id,
            'book_id'     => $request->book_id,
            'borrowed_at' => now(),
            'returned_at' => now()->addDays(7),
            'status'      => 'diproses',
        ]);

        return redirect()->route('home')->with('success', 'Buku berhasil dipinjam.');
    }

    public function edit(AmeliaBorrowing $ameliaBorrowing)
    {
        $books = AmeliaBook::all();
        $members = AmeliaMember::all();

        return view('borrowings.edit', [
            'borrowing' => $ameliaBorrowing,
            'books' => $books,
            'members' => $members,
        ]);
    }

    public function update(Request $request, AmeliaBorrowing $ameliaBorrowing)
    {
        $request->validate([
            'member_id'   => 'required|exists:amelia_members,id',
            'book_id'     => 'required|exists:amelia_books,id',
            'borrowed_at' => 'required|date',
            'returned_at' => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        $ameliaBorrowing->update($request->only('member_id', 'book_id', 'borrowed_at', 'returned_at'));

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(AmeliaBorrowing $ameliaBorrowing)
    {
        $ameliaBorrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function returnBook($id)
    {
        $borrowing = AmeliaBorrowing::with('member.user')->findOrFail($id);

        if ($borrowing->returned_at) {
            return back()->with('info', 'Buku sudah dikembalikan sebelumnya.');
        }

        $borrowing->returned_at = now();
        $borrowing->status = 'selesai';
        $borrowing->save();

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function verify($id)
    {
        $borrowing = AmeliaBorrowing::findOrFail($id);
        $borrowing->update(['status' => 'belum dikembalikan']);

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman telah diverifikasi.');
    }
}
