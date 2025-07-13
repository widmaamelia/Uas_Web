<?php

namespace App\Http\Controllers;

use App\Models\AmeliaBook;
use App\Models\AmeliaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmeliaBookController extends Controller
{
    // 📚 Halaman Index (Admin)
    public function index()
    {
        $books = AmeliaBook::with('category')->paginate(10);
        return view('books.index', compact('books'));
    }

    // 🏠 Halaman Home (User + Filter by Kategori & Search)
    public function home(Request $request)
    {
        $categoryId = $request->query('category');
        $searchTerm = $request->query('search');
        $navbarCategories = AmeliaCategory::all();

        $booksQuery = AmeliaBook::with('category');

        // 🔍 Jika ada pencarian
        if ($searchTerm) {
            $booksQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('author', 'like', '%' . $searchTerm . '%');
            });
        }

        // 📂 Jika filter kategori digunakan
        if ($categoryId) {
            $booksQuery->where('category_id', $categoryId);
        }

        $books = $booksQuery->get();

        return view('home', compact('books', 'navbarCategories'));
    }

    // ➕ Form Tambah Buku
    public function create()
    {
        $categories = AmeliaCategory::all();
        return view('books.create', compact('categories'));
    }

    // 💾 Simpan Buku Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'year'        => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:amelia_categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pdf_file'    => 'nullable|mimes:pdf|max:5120', // max 5MB
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('book_images', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('book_pdfs', 'public');
        }

        AmeliaBook::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // 👁️ Lihat Detail Buku
    public function show(AmeliaBook $ameliaBook)
    {
        return view('books.show', ['book' => $ameliaBook]);
    }

    // ✏️ Form Edit Buku
    public function edit(AmeliaBook $ameliaBook)
    {
        $categories = AmeliaCategory::all();
        $book = $ameliaBook;
        return view('books.edit', compact('book', 'categories'));
    }

    // 💾 Update Buku
    public function update(Request $request, AmeliaBook $ameliaBook)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'year'        => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:amelia_categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pdf_file'    => 'nullable|mimes:pdf|max:5120', // max 5MB
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($ameliaBook->image) {
                Storage::disk('public')->delete($ameliaBook->image);
            }
            $validated['image'] = $request->file('image')->store('book_images', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($ameliaBook->pdf_file) {
                Storage::disk('public')->delete($ameliaBook->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('book_pdfs', 'public');
        }

        $ameliaBook->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // 🗑️ Hapus Buku
    public function destroy(AmeliaBook $ameliaBook)
    {
        if ($ameliaBook->image) {
            Storage::disk('public')->delete($ameliaBook->image);
        }

        if ($ameliaBook->pdf_file) {
            Storage::disk('public')->delete($ameliaBook->pdf_file);
        }

        $ameliaBook->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
