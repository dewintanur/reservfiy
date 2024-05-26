@extends('layouts.app')

@section('title', 'Payment Success')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">

<div class="pembayaran-sukses mt-5">
  <div class="container-1 container bg-white rounded shadow p-4 text-center">
    <div class="payment-success display-5 fw-bold mb-3" style="color: #000;">
      Payment Success
    </div>
    <div class="you-have-successfully-sent-invoice fs-5 mb-3" style="color: #000;">
      You have successfully sent invoice
    </div>
    <div class="group-5 container bg-white rounded-3 shadow p-4 mb-3" style="max-width: 500px; margin: 0 auto;">
      <div class="no-invoice fs-6 mb-2 fw-bold" style="color: #000;">
        No Invoice
      </div>
      <div class="container fs-6 mb-2 fw-bold" style="color: #000;">
        {{ $reservation->id }}
      </div>
      <div class="total-invoice fs-6 mb-2 fw-bold" style="color: #000;">
        Total Invoice
      </div>
      <div class="rp-183000 fs-6 mb-2" style="color: #000;">
        Rp {{ number_format($reservation->package->price + ($reservation->package->price * 0.01), 2) }}
      </div>
      <div class="container-4 mt-3">
        <img class="iconbarcode" src="{{ $barcodeUrl }}" alt="Barcode" style="max-width: 100%; width: 200px;" />
      </div>
      <span class="payment-method fs-6" style="color: #000;">
        {{ $reservation->payment_method }}
      </span>
    </div>
  </div>
</div>
<div class="container text-center mt-3">
  <div class="bg-orange rounded-pill py-2 mb-3" 
    onclick="location.href='{{ route('payments.invoice', ['id' => $reservation->id]) }}'"
    style="background-color: #DC7C41; display: inline-block;">
    <span class="invoice fs-6 text-white btn btn-sm mx-auto px-5"> Invoice</span>
  </div>
</div>

@endsection
