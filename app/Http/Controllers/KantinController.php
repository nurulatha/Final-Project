<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\User;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantins = Kantin::all();
        return view('kantins.index-kantin', compact('kantins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('admin')->get();
        return view('kantins.form-kantin', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kantin' => 'required|max:100',
            'lokasi' => 'required|max:255',
            'user_id' => 'required|exists:users,id|unique:kantins,user_id'
        ]);

        Kantin::create($request->all());
        return redirect()->route('kantin.index')->with('success', 'Kantin Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kantin = Kantin::with('user')->findOrFail($id);
        $users = User::all();
        return view('kantins.detail-kantin', compact('kantin', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kantin = Kantin::with('user')->findOrFail($id);
        $users = User::role('admin')->get();
        return view('kantins.form-kantin', compact('kantin', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kantin' => 'required|max:100',
            'lokasi' => 'required|max:255',
            'user_id' => 'required|exists:users,id|unique:kantins,user_id,' . $id
        ]);
        $kantin = Kantin::findOrFail($id);
        $kantin->update($request->all());
        return redirect()->route('kantin.index')->with('success', 'Kantin Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kantin = Kantin::findOrFail($id);
        $kantin->delete();
        return redirect()->route('kantin.index')->with('success', 'Kantin Berhasil Dihapus');
    }
}
