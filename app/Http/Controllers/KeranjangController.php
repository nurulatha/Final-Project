<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('menu')->where('user_id', Auth::id())->get();
        return view('keranjangs.index', compact('keranjangs'));
    }

    public function store(Request $request, $menu_id)
{
    $menu = Menu::findOrFail($menu_id);

    $keranjang = Keranjang::where('user_id', Auth::id())
        ->where('menu_id', $menu_id)
        ->first();

    if ($keranjang) {
        $keranjang->increment('jumlah');
        $keranjang->refresh(); 
    } else {
        $keranjang = Keranjang::create([
            'user_id' => Auth::id(),
            'menu_id' => $menu_id,
            'jumlah' => 1,
        ]);
    }
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'menu_id' => $menu_id,
            'jumlah' => $keranjang->jumlah
        ]);
    }

    return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang!');
}
    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::with('menu')->find($id);

        if ($keranjang) {
            if ($request->action === 'plus') {
                $keranjang->jumlah++;
            } elseif ($request->action === 'minus' && $keranjang->jumlah > 1) {
                $keranjang->jumlah--;
            }

            $keranjang->save();

            $total = $keranjang->jumlah * $keranjang->menu->harga;

            return response()->json([
                'success' => true,
                'jumlah' => $keranjang->jumlah,
                'total' => $total
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $userId = auth()->id();

        $keranjang = Keranjang::with('menu')->where('user_id', $userId)->get();

        if ($keranjang->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $total = $keranjang->sum(fn($item) => $item->menu->harga * $item->jumlah);

        $pesanan = Pesanan::create([
            'user_id' => $userId,
            'total_harga' => $total,
            'payment_method' => $request->input('payment_method', 'cash'),
            'status' => 'diproses',
        ]);

        foreach ($keranjang as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $item->menu_id,
                'jumlah' => $item->jumlah,
                'subtotal' => $item->menu->harga * $item->jumlah,
            ]);
        }

        Keranjang::where('user_id', $userId)->delete();

        return redirect()->route('pesanan.show', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
