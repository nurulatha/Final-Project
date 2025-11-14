@extends('layouts.master')

@section('content')
<div class="container p-3">

    <div class="row">
        <div class="col-12 col-md-4">
        <div class="text-white shadow-sm card bg-primary h-100">
            <div class="card-body">
                <h5 class="card-title">Total Pengguna Terdaftar</h5> <br>
                <p class="card-text display-6">{{ $totalUsers }} Pengguna</p>
                <a href="{{ route('users.index') }}" class="text-white text-decoration-underline">Lihat Detail</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="text-white shadow-sm card bg-success h-100">
            <div class="card-body">
                <h5 class="card-title">Total Kantin Terdaftar</h5><br>
                <p class="card-text display-6">{{ $totalKantins }} Kantin</p>
                <a href="{{ route('kantin.index') }}" class="text-white text-decoration-underline">Lihat Detail</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="text-white shadow-sm card bg-warning h-100">
            <div class="card-body">
                <h5 class="card-title">Jumlah Seluruh Transaksi</h5><br>
                <p class="card-text display-6">{{ $totalPesanans }}</p>
                <a href="{{ route('users.index') }}" class="text-dark text-decoration-underline">Lihat Detail</a>
            </div>
        </div>
    </div>
    </div>


</div>


@endsection