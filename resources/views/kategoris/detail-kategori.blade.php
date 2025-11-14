@extends ('layouts.master')
@section('content')
<div class="container mt-4">
    <h3>Detail Kategori</h3>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $kategori->nama_kategori }}</h3> <br>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection