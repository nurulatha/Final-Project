@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($kategori) ? route('admin.kategori.update', $kategori->id) : route('admin.kategori.store') }}"
                method="POST">

                @csrf
                @if(isset($kategori))
                @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text"
                        name="nama_kategori"
                        class="form-control"
                        value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                        required>
                </div>


                <button type="submit" class="btn btn-primary">
                    {{ isset($kategori) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection