@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Keranjang Saya</h3>
    <table class="table mt-3 table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keranjangs as $item)
            <tr>
                <td>{{ $item->menu->nama_menu }}</td>
                <td id="harga-{{ $item->id }}" data-harga="{{ $item->menu->harga }}">Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-outline-secondary btn-minus" data-id="{{ $item->id }}" type="button">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span id="qty-{{ $item->id }}">{{ $item->jumlah }}</span>
                    <button class="btn btn-outline-secondary btn-plus" data-id="{{ $item->id }}" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
                <td id="total-{{ $item->id }}">
                    Rp{{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}
                </td>
                <td>
                    <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Keranjang kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($keranjangs->count())
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">
        Lanjut ke Pesanan
    </button>
    @endif

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah kamu yakin ingin melanjutkan ke pesanan?</p>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.btn-plus, .btn-minus').click(function() {
        let id = $(this).data('id');
        let action = $(this).hasClass('btn-plus') ? 'plus' : 'minus';

        $.ajax({
            url: '/keranjang/' + id,
            method: 'PUT',
            data: {
                action: action,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.success) {
                    $('#qty-' + id).text(res.jumlah);
                    const harga = parseInt($('#harga-' + id).data('harga'));
                    $('#total-' + id).text('Rp' + (harga * res.jumlah).toLocaleString('id-ID'));
                }
            }
        });
    });
</script>
@endpush