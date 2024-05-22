@extends('layouts.app')

@section('title', 'Pay for Reservation')

@section('content')
<div class="container">
    <h1>Complete Your Payment</h1>
    <form action="{{ route('payments.store') }}" method="post">
        @csrf
        <!-- Hidden field for reservation ID -->
        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

        <div class="form-group mb-3">
            <label for="amount">Total Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $reservation->total_price }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label for="credit_card">Credit Card Number</label>
            <input type="text" class="form-control" id="credit_card" name="credit_card" required placeholder="Enter your credit card number">
        </div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div>
@endsection
