@extends ('layouts.master')
@section('content')
<div class="container mt-4">
    <h3>Detail User</h3>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $user->name }}</h3> <br>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->getRoleNames()->first() }}</p>
            <p>{{ $user->bio ?: '-' }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection