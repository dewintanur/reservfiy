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
    }

    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/rectangle17061.jpeg') no-repeat center center/cover;
        color: #fff;
        height: 700px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        /* Menyesuaikan ukuran gambar untuk menutupi seluruh area */
        background-position: center;
    }

    .arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        color: white;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .arrow:hover {
        opacity: 0.7;
    }

    .arrow-left {
        left: 20px;
    }

    .arrow-right {
        right: 20px;
    }

    .hero-search {
        width: 40%;
        padding: 20px;
        border-radius: 50px;
        justify-content: center;
        align-items: center;
    }

    .container.my-4 {
        text-align: center;
    }

    .custom-input {
        width: 100%;
        border-radius: 20px;
    }

    .section-title {
        font-size: 28px;
        color: #5B3708;
        margin: 40px 0 20px;
        text-align: left;
    }

    .row {
        margin: 0;
        width: 100%;
        display: flex;
        justify-content: space-around;
    }

    .card.custom-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        margin: 10px;
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
    }

    .btn-custom:hover {
        background-color: #3e2505;
        color: #ffffff;
    }

    .promotion-card,
    .reservation-card {
        border: none;
    }

    .text-chocolate {
        color: #5B3708;
    }

    .card-img-overlay {
        display: flex;
        align-items: flex-end;
        padding: 0;
    }

    .overlay-text {
        background: rgba(0, 0, 0, 0.50);
        width: 100%;
        height: 50%;
        padding: 15px;
        text-align: center;
        border-radius: 0 0px 30px 30px;
    }

    .description {
        font-size: 30px;
        color: #D19F63;
        font-weight: 500;
    }

    .card-title {
        margin: 0;
        font-size: 1.25rem;
        display: inline;
    }

    .card-location {
        font-size: 1rem;
        color: #888;
        margin-left: auto;
        margin-right: 0;
        display: inline;
    }

    .detail {
        justify-content: flex-start;
        background-color: #D19F63;
        border-radius: 30px;
    }
</style>

<div class="container-fluid p-0">
    <div class="hero-section">
        <div class="hero-search d-flex flex-column align-items-center">
            <form method="GET" action="{{ route('cafes.search') }}" class="w-100">
                <div class="mb-3">
                    <input type="text" name="search" class="form-control custom-input align-items-center"
                        placeholder="Search cafes by name, category, or location">
                </div>
                <div class="d-flex justify-content-center w-100">
                    <button type="submit" class="btn btn-custom mt-3">Search</button>
                </div>
            </form>
        </div>
        <div class="arrow arrow-left" onclick="changeBackground('prev')"><i class="bi bi-arrow-left"></i></div>
        <div class="arrow arrow-right" onclick="changeBackground('next')"><i class="bi bi-arrow-right"></i></div>
    </div>

    <div class="container my-4" id="bestCafes">
    <h2 class="section-title">Best Cafes</h2>
    <div class="row">
        @foreach($cafes->take(3) as $cafe)
            <div class="col-md-3 mb-3">
                <div class="card custom-card">
                    <div class="carousel">
                        <div class="carousel-inner">
                            <img src="{{ asset('storage/' . $cafe->photo) }}" class="carousel-item active" alt="{{ $cafe->name }}">
                            <img src="{{ asset('storage/' . $cafe->menu) }}" class="carousel-item active" alt="{{ $cafe->name }}">

                            <!-- Tambahkan gambar-gambar tambahan di sini jika diperlukan -->
                        </div>
                        <a class="carousel-control-prev" href="#bestCafes" role="button" onclick="prevSlide(this)">
                            <span class="carousel-control-icon" aria-hidden="true">&lt;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#bestCafes" role="button" onclick="nextSlide(this)">
                            <span class="carousel-control-icon" aria-hidden="true">&gt;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $cafe->name }}</h5>
                            <p class="card-location">{{ $cafe->location }}</p>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('cafes.show', $cafe->id) }}" class="btn btn-custom detail mt-3">Detail
                                Cafe</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


        <div class="row mt-5">
            <div class="col-md-4 mb-3">
                <div class="card promotion-card text-white">
                    <img src="{{ asset('images/image1.png') }}" class="card-img" alt="Promotion Image 1">
                    <div class="card-img-overlay">
                        <div class="overlay-text">
                            <p class="card-text description">30% off in New York Cafes!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card promotion-card text-white">
                    <img src="{{ asset('images/image2.png') }}" class="card-img" alt="Promotion Image 2">
                    <div class="card-img-overlay">
                        <div class="overlay-text">
                            <p class="card-text description">Buy 1 Get 1 Free in Tokyo!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card promotion-card text-white">
                    <img src="{{ asset('images/image3.png') }}" class="card-img" alt="Promotion Image 3">
                    <div class="card-img-overlay">
                        <div class="overlay-text">
                            <p class="card-text description">Special discounts available!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($reservations->count() > 0)
            <div class="row mt-5">
                <div class="col-md-12 mb-3">
                    <div class="card reservation-card">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center"
                                    style="background-color: transparent;">
                                    <h5 class="card-title text-center mb-0" style="font-size: 24px; color: #5B3708;">
                                        Last Cafe</h5>
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
                                        <img src="{{ asset('storage/' . $reservations->get(1)->cafe->photo) }}" class="card-img"
                                            alt="{{ $reservations->get(1)->cafe->name }}" style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center">No reservations found.</p>
        @endif
    </div>
</div>
@endsection
<script>
    let currentBackgroundIndex = 0;
    const backgrounds = [
        'url(/images/image1.png)',
        'url(/images/image2.png)',
        'url(/images/rectangle17061.jpeg)'
    ];

    function changeBackground(direction) {
        if (direction === 'prev') {
            currentBackgroundIndex = (currentBackgroundIndex === 0) ? backgrounds.length - 1 : currentBackgroundIndex - 1;
        } else {
            currentBackgroundIndex = (currentBackgroundIndex === backgrounds.length - 1) ? 0 : currentBackgroundIndex + 1;
        }
        document.querySelector('.hero-section').style.backgroundImage = backgrounds[currentBackgroundIndex];
    }
    
function changeBackground() {
    currentBackgroundIndex = (currentBackgroundIndex + 1) % backgrounds.length;
    document.querySelector('.hero-section').style.backgroundImage = backgrounds[currentBackgroundIndex];
}

// Ganti latar belakang setiap 5 detik
setInterval(changeBackground, 5000);

function scrollToBestCafes() {
        const bestCafesSection = document.getElementById('bestCafes');
        bestCafesSection.scrollIntoView({ behavior: 'smooth' });
    }
 
function nextSlide(element) {
    const carousel = element.closest('.carousel');
    const carouselItems = carousel.querySelectorAll('.carousel-item');
    const currentActiveIndex = Array.from(carouselItems).findIndex(item => item.classList.contains('active'));
    carouselItems[currentActiveIndex].classList.remove('active');
    let nextIndex = currentActiveIndex + 1;
    if (nextIndex >= carouselItems.length) {
        nextIndex = 0;
    }
    carouselItems[nextIndex].classList.add('active');
}

function prevSlide(element) {
    const carousel = element.closest('.carousel');
    const carouselItems = carousel.querySelectorAll('.carousel-item');
    const currentActiveIndex = Array.from(carouselItems).findIndex(item => item.classList.contains('active'));
    carouselItems[currentActiveIndex].classList.remove('active');
    let prevIndex = currentActiveIndex - 1;
    if (prevIndex < 0) {
        prevIndex = carouselItems.length - 1;
    }
    carouselItems[prevIndex].classList.add('active');
}

</script>