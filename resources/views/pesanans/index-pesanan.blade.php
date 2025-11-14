@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Daftar Pesanan Saya</h3>

    @if($pesanans->isEmpty())
    <p>Belum ada pesanan.</p>
    @else
    <table class="table mt-3 table-bordered" id="pesanan">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Detail</th>
                @if(Auth::user()->hasRole('admin'))
                <th>Ubah Status</th>
                @else
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($pesanans as $pesanan)
            <tr>
                <td>{{ $pesanan->id }}</td>
                <td>{{ $pesanan->created_at->format('d-m-Y H:i') }}</td>
                <td>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span class="badge 
                            @if($pesanan->status == 'diproses') bg-warning 
                            @elseif($pesanan->status == 'selesai') bg-success 
                            @else bg-danger @endif">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </td>
                <td>
                    <ul class="mb-0">
                        @foreach($pesanan->detailPesanans as $detail)
                        <li>{{ $detail->menu->nama_menu }} (x{{ $detail->jumlah }})</li>
                        @endforeach
                    </ul>
                </td>
                @if(Auth::user()->hasRole('admin'))
                <td>
                    <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ $pesanan->status == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </form>
                </td>
                @endif
                @if(Auth::user()->hasRole('admin'))
                <td>
                    <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="btn btn-info btn-sm">Detail</a>
                </td>
                @else
                <td>
                    <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn btn-info btn-sm">Detail</a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection