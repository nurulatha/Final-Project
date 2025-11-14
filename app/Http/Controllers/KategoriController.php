<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantin = Kantin::where('user_id', Auth::id())->first();

        $kategoris = $kantin
            ? Kategori::where('kantin_id', $kantin->id)->get()
            : collect();

        return view('kategoris.index-kategori', compact('kategoris'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategoris.form-kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);

        $kantin = Kantin::where('user_id', Auth::id())->first();
        if (!$kantin) {
            return redirect()->back()->with('error', 'Kantin tidak ditemukan untuk akun ini.');
        }

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'kantin_id' => $kantin->id,
        ]);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.detail-kategori', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.form-kategori', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Berhasil Dihapus');
    }
}
