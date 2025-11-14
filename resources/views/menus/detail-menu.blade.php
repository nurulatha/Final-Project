@extends ('layouts.master')
@section('content')
<div class="container mt-4">
    <h3>Detail Menu</h3>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $menu->nama_menu }}</h3> <br>
            <p><strong>Lokasi: </strong> {{ $menu->kantin->nama_kantin ?? '-' }}</p>
            <p><strong>Kategori: </strong> {{ $menu->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Harga: </strong>{{ $menu->harga }}</p>
            <p><strong>Deskripsi: </strong>{{ $menu->deskripsi }}</p>
            <p>
                @if($menu->gambar)
                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="Gambar Menu" width="100">
                @else
                <span class="text-muted">Tidak ada gambar</span>
                @endif
            </p>
            @if(Auth::user()->hasRole('admin'))
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Kembali</a>
            @else
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">Kembali</a>
            @endif
        </div>
    </div>
</div>

@endsection