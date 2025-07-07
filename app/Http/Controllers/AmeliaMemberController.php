<?php

namespace App\Http\Controllers;

use App\Models\AmeliaMember;
use Illuminate\Http\Request;

class AmeliaMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = AmeliaMember::all();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'nim'     => 'required|string|max:20|unique:amelia_members,nim',
            'email'   => 'required|email|unique:amelia_members,email',
            'jurusan' => 'required|string|max:100',
        ]);

        AmeliaMember::create($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AmeliaMember $ameliaMember)
    {
        // Optional: implement if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AmeliaMember $ameliaMember)
    {
        return view('members.edit', compact('ameliaMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AmeliaMember $ameliaMember)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'nim'     => 'required|string|max:20|unique:amelia_members,nim,' . $ameliaMember->id,
            'email'   => 'required|email|unique:amelia_members,email,' . $ameliaMember->id,
            'jurusan' => 'required|string|max:100',
        ]);

        $ameliaMember->update($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AmeliaMember $ameliaMember)
    {
        $ameliaMember->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
