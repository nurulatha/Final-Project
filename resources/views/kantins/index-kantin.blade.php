@extends('layouts.master')
@section('title')
<h3 class="px-3">Daftar Kantin</h3>
@endsection
@section('content')
<div class="container px-3">
    <a href="{{ route('kantin.create') }}" class="mb-3 btn btn-primary"> Tambah Kantin </a>
    <table id="kantin" class="table mt-4 table-bordered">
        <thead>
            <th>No</th>
            <th>Nama Kantin</th>
            <th>Pemilik</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </thead>
            <tbody>
                @foreach ($kantins as $index => $kantin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kantin->nama_kantin }}</td>
                    <td>{{ $kantin->user->name ?? 'No Owner' }}</td>
                    <td>{{ $kantin->lokasi }}</td>
                    <td>
                        <a href="{{ route('kantin.show', $kantin->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('kantin.edit', $kantin->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kantin.destroy', $kantin->id) }}" method="POST" style="display:inline;">
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
        $("#kantin").DataTable();
    });
</script>
@endpush


@endsection