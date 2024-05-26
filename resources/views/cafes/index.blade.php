@extends('layouts.app')

@section('title', 'List of Cafes')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <h2 class="mb-4">
        @if($searchQuery)
           {{ $searchQuery }}
        @else
            Cafe
        @endif
    </h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($cafes as $cafe)
        <div class="col">
            <div class="card h-100 shadow" style="border-radius: 20px;">
                <div class="bg-white p-2" style="border-radius: 20px 20px 0 0; overflow: hidden; border: 5px solid white;">
                    <img src="{{ asset('storage/' . $cafe->photo) }}" class="card-img-top" alt="Photo of {{ $cafe->name }}" style="height: 200px; object-fit: cover;">
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">{{ $cafe->name }}</h5>
                        <span class="badge text-dark">
                            <i class="bi bi-star-fill" style="color: yellow;"></i> {{ $cafe->rating }}
                        </span>
                    </div>
                    <p class="card-text">{{ $cafe->location }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="text-primary fw-bold">
                            @if ($cafe->lowest_package_price)
                                Rp{{ number_format($cafe->lowest_package_price, 3, '.', '.') }}
                            @else
                                No packages available
                            @endif
                        </span>
                        <a href="{{ route('cafes.show', $cafe->id) }}"
                           class="btn {{ $cafe->isAvailable(now()) ? 'btn-success' : 'btn-secondary disabled' }} rounded-pill"
                           style="width: 100px; font-size: 12px;">
                            {{ $cafe->isAvailable(now()) ? 'Available' : 'Not Available' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
