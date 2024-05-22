@extends('layouts.admin')

@section('title', 'Edit Reservation')

@section('content')
<div class="container mt-4">
    <h1>Edit Reservation</h1>
    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user" class="form-label">User</label>
            <input type="text" class="form-control" id="user" value="{{ $reservation->user->name }}" readonly>
        </div>
        <div class="mb-3">
            <label for="cafe" class="form-label">Cafe</label>
            <input type="text" class="form-control" id="cafe" value="{{ $reservation->cafe->name }}" readonly>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $reservation->date }}">
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" value="{{ $reservation->time }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
