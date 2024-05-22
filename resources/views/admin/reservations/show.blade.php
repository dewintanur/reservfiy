@extends('layouts.admin')

@section('title', 'Reservation Details')

@section('content')
<div class="container mt-4">
    <h1>Reservation Details</h1>
    <div class="card">
        <div class="card-header">
            Reservation ID: {{ $reservation->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">User: {{ $reservation->user->name }}</h5>
            <p class="card-text">Cafe: {{ $reservation->cafe->name }}</p>
            <p class="card-text">Date: {{ $reservation->date }}</p>
            <p class="card-text">Time: {{ $reservation->time }}</p>
            <p class="card-text">Status: {{ $reservation->status }}</p>
            <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
