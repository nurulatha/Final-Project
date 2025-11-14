<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $kantin = Kantin::where('user_id', Auth::id())->first();
            $menus = $kantin ? Menu::where('kantin_id', $kantin->id)->get() : collect();
            return view('menus.index-menu', compact('menus'));
        } else {
            $kantins = Kantin::all();
            return view('menus.index-menu', compact('kantins'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kantin = Kantin::where('user_id', Auth::id())->first();
        $kategoris = $kantin
            ? Kategori::where('kantin_id', $kantin->id)->get()
            : collect();

        return view('menus.form-menu', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_menu' => 'required|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $kantin = Kantin::where('user_id', Auth::id())->first();
        if (!$kantin) {
            return redirect()->back()->with('error', 'Kantin tidak ditemukan.');
        }

        $validatedData['kantin_id'] = $kantin->id;

        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        Menu::create($validatedData);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('menus.detail-menu', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        $kantin = Kantin::where('user_id', Auth::id())->first();

        $kategoris = $kantin ? Kategori::where('kantin_id', $kantin->id)->get() : collect();

        return view('menus.form-menu', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_menu' => 'required|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(storage_path('app/public/' . $menu->gambar))) {
                unlink(storage_path('app/public/' . $menu->gambar));
            }

            $data['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function getByKantin($kantin_id)
    {
        $menus = Menu::with('kategori')
            ->where('kantin_id', $kantin_id)
            ->get();
        return response()->json($menus);
    }
}
