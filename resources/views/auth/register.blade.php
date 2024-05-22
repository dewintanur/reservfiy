@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">

<div class="container py-5">
    <div class="row align-items-center">
        <!-- Teks Signup di sisi kiri -->
        <div class="col-md-6">
            <h1 class="display-4" style="font-family: 'Sora', sans-serif; color: #5B3708;">signup<br>and Grab Your First Seat!</h1>
        </div>
        <!-- Form di sisi kanan -->
        <div class="col-md-6">
            <div class="p-5 shadow bg-white rounded-3" style="border-radius: 30px;">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/reservfiy63.png') }}" alt="Logo" style="width: 100px; height: auto;">
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label" style="font-family: 'Sora', sans-serif;">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label" style="font-family: 'Sora', sans-serif;">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label" style="font-family: 'Sora', sans-serif;">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label" style="font-family: 'Sora', sans-serif;">Retype Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn" style="background-color: #8B4513; color: white;">signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection