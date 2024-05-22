@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Sora', sans-serif;
        background-color: #ffffff;
        /* Unified white background */
    }

    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/rectangle17061.jpeg') no-repeat center center/cover;
        color: #fff;
        height: 700px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-search {
        width: 40%;
        padding: 20px;
        border-radius: 50px;
        justify-content: center;
        /* Centers horizontally */
        align-items: center;
        /* Centers vertically (if needed) */
    }

    .container.my-4 {
        text-align: center;
        /* Ensures that titles and text are centered above the cards */
    }

    .custom-input {
        width: 100%;
        /* Makes the input wider */
        border-radius: 20px;
        /* Rounds the corners */
    }

    .section-title {
        font-size: 28px;
        color: #5B3708;
        /* Chocolate color for titles */
        margin: 40px 0 20px;
        text-align: left;
        /* Aligns the text to the left */
    }

    .row {
        margin: 0;
        /* Removes default margin to allow better centering */
        width: 100%;
        /* Ensures the row takes full available width */
        display: flex;
        justify-content: space-around;
    }

    .card.custom-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        margin: 10px;
        /* Add horizontal margin for spacing between cards */
    }

    .card.custom-card img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .btn-custom {
        background-color: #5B3708;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
        justify-content: center;
    }

    .btn-custom:hover {
        background-color: #3e2505;
        color: #ffffff;
    }

    .promotion-card,
    .reservation-card {
        /* background: #F0E8D9; */
        border: none;
    }

    .text-chocolate {
        color: #5B3708;
        /* Chocolate color text */
    }
</style>

<div class="container-fluid p-0">
<div class="hero-section">
    <div class="hero-search d-flex flex-column align-items-center">
        <form method="GET" action="{{ route('cafes.search') }}" class="w-100">
            <div class="mb-3">
                <input type="text" name="search" class="form-control custom-input align-items-center" placeholder="Search cafes by name, category, or location">
            </div>
            <div class="d-flex justify-content-center w-100"> <!-- Tambahkan class ini -->
            <button type="submit" class="btn btn-custom mt-3">Search</button>
            </div>
        </form>
    </div>
</div>
    <div class="container my-4">
        <h2 class="section-title">Best Cafes</h2>
        <div class="row">
            @foreach($cafes->take(3) as $cafe)
                <div class="col-md-3 mb-3">
                    <div class="card custom-card">
                        <img src="{{ asset('storage/' . $cafe->photo) }}" alt="{{ $cafe->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cafe->name }}</h5>
                            <p class="card-text">{{ $cafe->description }}</p>
                            <a href="{{ route('cafes.show', $cafe->id) }}" class="btn btn-custom">Detail Cafe</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="card promotion-card text-white">
                        <img src="{{ asset('images/image1.png') }}" class="card-img" alt="Promotion Image 1">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                            <div class="bg-dark bg-opacity-75 p-5 rounded overlay-text">
                                <p class="card-text">30% off in New York Cafes!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card promotion-card text-white">
                        <img src="{{ asset('images/image2.png') }}" class="card-img" alt="Promotion Image 2">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                            <div class="bg-dark bg-opacity-75 p-5 rounded overlay-text">
                                <p class="card-text">Buy 1 Get 1 Free in Tokyo!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card promotion-card text-white">
                        <img src="{{ asset('images/image3.png') }}" class="card-img" alt="Promotion Image 3">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                            <div class="bg-dark bg-opacity-75 p-5 rounded overlay-text">
                                <p class="card-text">Special discounts available!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
            @if ($reservations->count() > 0)
                <div class="col-md-12 mb-3">
                    <div class="card reservation-card">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center"
                                    style="background-color: transparent;">
                                    <h5 class="card-title text-center mb-0" style="font-size: 24px; color: #5B3708;">
                                        Last
                                        Cafe</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-img-container p-3 rounded-pill">
                                    <img src="{{ asset('storage/' . $reservations->first()->cafe->photo) }}"
                                        class="card-img" alt="{{ $reservations->first()->cafe->name }}"
                                        style="max-height: 300px;">
                                </div>
                            </div>
                            @if ($reservations->count() > 1)
                                <div class="col-md-4">
                                    <div class="card-img-container p-3 rounded-pill">
                                        <img src="{{ asset('storage/' . $reservations->get(1)->cafe->photo) }}"
                                            class="card-img" alt="{{ $reservations->get(1)->cafe->name }}"
                                            style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center">No reservations found.</p>
            @endif
        </div>
            </div>
            @endsection