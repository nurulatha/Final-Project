@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h3>
    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                method="POST">

                @csrf
                @if(isset($user))
                @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="umur" class="form-label">Email</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Password</label>
                    <input type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : '' }}"
                        {{ !isset($user) ? 'required' : '' }}>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>

                        @php
                        $userRole = isset($user) ? optional($user->getRoleNames())->first() : null;
                        @endphp

                        @foreach ($roles as $roleName)
                        <option value="{{ $roleName }}"
                            {{ old('role', $userRole) == $roleName ? 'selected' : '' }}>
                            {{ ucfirst($roleName) }}
                        </option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($user) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection