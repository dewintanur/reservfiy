@extends('layouts.app')

@section('title', 'Cafe Details')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5 detail-cafe">
    <h2 class="mb-4 fs-1 fw-bold">Detail Cafe</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="border: none;">
                <div class="card-body mt-3 fs-5">
                    <div class="row mb-3 mt-4">
                        <div class="col-sm-4">
                            <strong>Nama Cafe:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $cafe->name }}
                        </div>
                    </div>
                    <div class="row mb-3 mt-5">
                        <div class="col-sm-4">
                            <strong>Deskripsi:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $cafe->description }}
                        </div>
                    </div>
                    <div class="row mb-3 mt-5">
                        <div class="col-sm-4">
                            <strong>Jam Operasional:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $formattedHoursString }}
                        </div>
                    </div>
                    <div class="mt-5 pt-5">
                        <a href="{{ route('reservations.book', $cafe->id) }}" class="btn" style="background-color: #8B4513; color: white;">Book Now</a>
                        <button onclick="window.history.back();" class="btn" style="background-color: #D2B48C; color: white;">Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div id="cafeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $cafe->photo) }}" alt="Photo of {{ $cafe->name }}" class="d-block w-100" style="border-radius: 50px; width: 300px; height: 300px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/' . $cafe->menu) }}" alt="Menu of {{ $cafe->name }}" class="d-block w-100" style="border-radius: 50px; width: 300px; height: 300px; object-fit: cover;">
                    </div>
                    <!-- Tambahkan gambar-gambar tambahan di sini jika diperlukan -->
                </div>
                <a class="carousel-control-prev" href="#cafeCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#cafeCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

            <div class="d-flex flex-column align-items-start w-100 mt-3">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2 fw-bold">
                    <span>{{ $cafe->location }}</span>
                    <span><i class="bi bi-star-fill text-warning"></i> {{ $cafe->rating }}</span>
                </div>

                <a href="{{ $cafe->maps_link }}" class="btn w-100 mb-2 d-flex align-items-center justify-content-start">
                    <i class="bi bi-geo-alt-fill me-2"></i> Google Maps
                </a>
                <a href="{{ $cafe->social_media }}" class="btn w-100 d-flex align-items-center justify-content-start">
                    <i class="bi bi-instagram me-2"></i> {{ '@' . parseInstagramUsername($cafe->social_media) }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.detail-cafe .card {
    border: none;
}
.detail-cafe .btn {
    border-radius: 20px;
    margin-bottom: 10px;
    color: inherit;
    background-color: inherit;
    text-align: left;
}
.detail-cafe .d-flex {
    padding-inline: 30px;
    width: 100%;
}
</style>

@php
function parseInstagramUsername($url) {
    return basename(parse_url($url, PHP_URL_PATH));
}
@endphp
