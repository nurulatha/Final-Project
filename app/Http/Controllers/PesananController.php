<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $kantin = Kantin::where('user_id', Auth::id())->first();

            if ($kantin) {
                $pesanans = Pesanan::whereHas('detailPesanans.menu', function ($query) use ($kantin) {
                    $query->where('kantin_id', $kantin->id);
                })
                    ->with(['detailPesanans.menu', 'user'])
                    ->get();
            } else {
                $pesanans = collect();
            }
        } else {
            $pesanans = Pesanan::where('user_id', Auth::id())
                ->with(['detailPesanans.menu'])
                ->get();
        }

        return view('pesanans.index-pesanan', compact('pesanans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::with('detailPesanans.menu')->findOrFail($id);

        return view('pesanans.detail-pesanan', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai,batal',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
