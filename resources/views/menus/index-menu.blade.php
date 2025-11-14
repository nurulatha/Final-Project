@extends('layouts.master')


@section('content')
<div class="container px-3">
    @hasrole('pembeli')
    <div class="mb-3">
        <label for="kantin" class="form-label">Pilih Kantin</label>
        <select id="kantin" class="form-select">
            <option value="">-- Pilih Kantin --</option>
            @foreach($kantins as $kantin)
            <option value="{{ $kantin->id }}">{{ $kantin->nama_kantin }}</option>
            @endforeach
        </select>
    </div>

    <div id="menu-container" style="display:none;">
        <table class="table mt-2 table-bordered" id="menu">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Image</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="menu-body">
            </tbody>
        </table>
    </div>
    @endhasrole

    @hasrole('admin')
    <h2>Daftar Menu</h2>
    <a href="{{ route('admin.menu.create') }}" class="mb-3 btn btn-primary"> Tambah Menu </a>
    @if (session('success'))
    @endif
    <table class="table mt-2 table-bordered" id="menu">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Image</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $index => $menu)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $menu->nama_menu }}</td>
                <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $menu->harga }}</td>
                <td>{{ $menu->deskripsi ?? '' }}</td>
                <td>
                    @if($menu->gambar)
                    <img src="{{ asset($menu->gambar) }}" width="100">
                    @else
                    <span class="text-muted">Tidak ada gambar</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.menu.show', $menu->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endhasrole
</div>

@hasrole('pembeli')
<script>
    document.getElementById('kantin').addEventListener('change', function() {
        const kantinId = this.value;
        const container = document.getElementById('menu-container');
        const tbody = document.getElementById('menu-body');
        tbody.innerHTML = '';
        container.style.display = 'none';

        if (!kantinId) return;

        fetch(`/menu/by-kantin/${kantinId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Belum ada menu di kantin ini.</td></tr>`;
                    container.style.display = 'block';
                    return;
                }

                container.style.display = 'block';

                data.forEach((menu, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${index + 1}</td>
                <td>${menu.nama_menu}</td>
                <td>${menu.kategori ? menu.kategori.nama_kategori : '-'}</td>
                <td>${menu.harga}</td>
                <td>${menu.deskripsi ?? ''}</td>
                <td>
                    ${menu.gambar 
                        ? `<img src="/${menu.gambar}" alt="Gambar Menu" width="100">`
                        : `<span class="text-muted">Tidak ada gambar</span>`}
                </td>
                <td>
                    <button class="btn btn-success btn-sm add-cart" data-id="${menu.id}">Tambah ke Keranjang</button>
                </td>
            `;
                    tbody.appendChild(row);
                });

                document.querySelectorAll('.add-cart').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const menuId = this.dataset.id;
                        fetch(`/keranjang/${menuId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    action: 'plus'
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Menu telah ditambahkan ke keranjang.'
                                    });
                                }
                            })
                            .catch(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan.'
                                });
                            });
                    });
                });

            })
            .catch(() => {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Gagal memuat data menu.</td></tr>`;
                container.style.display = 'block';
            });
    });
</script>
@endhasrole
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
        $("#menu").DataTable();
    });
</script>
@endpush

@endsection