@extends ('layouts.master')
@section('content')
<div class="container mt-4">
    <h3>Detail Kantin</h3>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $kantin->nama_kantin }}</h3> <br>
            <p><strong>Pemilik: </strong> {{ $kantin->user->name ?? '-' }}</p>
            <p><strong>Lokasi: </strong>{{ $kantin->lokasi }}</p>
            <a href="{{ route('kantin.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection