@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>{{ isset($kantin) ? 'Edit Kantin' : 'Tambah Kantin' }}</h3>
    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($kantin) ? route('kantin.update', $kantin->id) : route('kantin.store') }}"
                method="POST">

                @csrf
                @if(isset($kantin))
                @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nama_kantin" class="form-label">Nama Kantin</label>
                    <input type="text"
                        name="nama_kantin"
                        class="form-control"
                        value="{{ old('nama_kantin', $kantin->nama_kantin ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Pemilik Kantin</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pemilik --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $kantin->user_id ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        value="{{ old('lokasi', $kantin->lokasi ?? '') }}"
                        required>
                </div>


                <button type="submit" class="btn btn-primary">
                    {{ isset($kantin) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('kantin.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection