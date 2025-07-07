<?php

namespace App\Http\Controllers;

use App\Models\AmeliaCategory;
use Illuminate\Http\Request;

class AmeliaCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $categories = AmeliaCategory::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:amelia_categories,name',
        ]);

        AmeliaCategory::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AmeliaCategory $ameliaCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AmeliaCategory $ameliaCategory)
    {
        $category = $ameliaCategory; // alias agar variabel dikenali di view
    return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AmeliaCategory $ameliaCategory)
    {
        $request->validate([
            'name' => 'required|unique:amelia_categories,name,' . $ameliaCategory->id,
        ]);

        $ameliaCategory->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AmeliaCategory $ameliaCategory)
    {
        $ameliaCategory->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
