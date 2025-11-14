@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Detail Pesanan</h3>

    <div class="mt-3 card">
        <div class="card-body">
            <p><strong>ID Pesanan:</strong> {{ $pesanan->id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ strtoupper($pesanan->payment_method) }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <h5 class="mt-4">Detail Item</h5>
    <table class="table mt-2 table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanans as $item)
            <tr>
                <td>{{ $item->menu->nama_menu }}</td>
                <td>Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(Auth::user()->hasRole('admin'))
    <a href="{{ route('admin.pesanan.index') }}" class="mt-3 btn btn-secondary">Kembali</a>
    @else
    <a href="{{ route('pesanan.index') }}" class="mt-3 btn btn-secondary">Kembali</a>
    @endif
</div>
@endsection