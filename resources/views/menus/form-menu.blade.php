@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>{{ isset($menu) ? 'Edit Menu' : 'Tambah Menu' }}</h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($menu) ? route('admin.menu.update', $menu->id) : route('admin.menu.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($menu)) @method('PUT') @endif

                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-control"
                        value="{{ old('nama_menu', $menu->nama_menu ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control"
                        value="{{ old('harga', $menu->harga ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $menu->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    @if(isset($menu) && $menu->gambar)
                    <img src="{{ asset('storage/'.$menu->gambar) }}" width="100" class="mt-2">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>

        </div>
    </div>
</div>
@endsection