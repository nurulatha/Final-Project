@extends('layouts.master')
@section('title')
<h3 class="px-3">Daftar Kategori</h3>
@endsection
@section('content')
<div class="container px-3">
    <a href="{{ route('admin.kategori.create') }}" class="mb-3 btn btn-primary"> Tambah Kategori </a>

    <table class="table mt-4 table-bordered" id="kategori">
        <thead>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @foreach ($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>
                    <a href="{{ route('admin.kategori.show', $kategori->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/dataTables.bootstrap5.css') }}">
@endpush

@push('scripts')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}"
        });
    });
</script>
@endif

<script src="{{ asset('plugins/datatables/js/dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>
<script>
    $(function() {
        $("#kategori").DataTable();
    });
</script>

@endpush


@endsection