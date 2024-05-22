@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Riwayat Reservasi</h1>
    <ul>
        @foreach ($reservations as $reservation)
            <li>{{ $reservation->details }} - {{ $reservation->status }}</li>
        @endforeach
    </ul>
</div>
@endsection
