@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

<div class="container py-5">
    <h1 class=" mb-4">Riwayat Pesanan</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($reservations as $reservation)
        <div class="col">
            <div class="card shadow-sm border-0 rounded-20">
                <div class="py-3 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>{{ $reservation->cafe->name }}, {{ $reservation->cafe->location }}</h4>
                        <p class="mb-0"></p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Order By</strong></p>
                    <p>{{ $reservation->user->name }}</p>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Date<i class="bi bi-calendar px-2"></i></strong></p>
                            <p>{{ $reservation->reservation_date }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Time<i class="bi bi-clock px-2"></i></strong></p>
                            <p>{{ $reservation->reservation_time }}</p>
                        </div>
                    </div>
                    <p><strong>No Invoice:</strong></p>
                    <ul>
                        <li>{{ $reservation->id }}</li>
                    </ul>
                </div>
                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary mb-3">Lihat Detail</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
<style>
    /* Custom style */
.card {
    border-radius: 20px !important; /* Lebih rounded */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    transition: transform 0.2s, box-shadow 0.2s !important;
}

.card:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 20px;
}

.card-title {
    color: #333;
    font-size: 1.2em;
    font-weight: bold;
}

.card-text {
    margin-bottom: 15px;
    font-size: 1em;
}

.btn-primary {
    color: #fff;
    background-color: #8B4513 !important; /* Warna coklat */
    border-color: #8B4513 !important;
    font-size: 0.875em; /* Ukuran button kecil */
    padding: 0.5em 1em; /* Padding button kecil */
    display: block;
    margin: 0 auto; /* Button di tengah */
    border-radius: 50px !important;
}

.btn-primary:hover {
    background-color: #5a2d0c !important;
    border-color: #5a2d0c !important;
}

</style>