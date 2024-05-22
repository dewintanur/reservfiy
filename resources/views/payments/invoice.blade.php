@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .invoice-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        padding: 0 15px; /* Memberikan jarak di pinggir kiri dan kanan */
    }
    .invoice-title {
        font-size: 34px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: left;
        align-self: flex-start; /* Agar title berada di kiri */
        padding-left: 15px; /* Tambahkan padding untuk memberi jarak dengan tepi kiri */
    }
    .invoice-card {
        border: none;
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 400px;
        max-width: 600px;
        text-align: left; /* Atur text-align ke kiri */
    }
    .invoice-body {
        padding:5px 50px;
    }
    .list-group-item {
        border: none;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        text-align: left !important;
    } 
    .list-group-items {
        border: none;
        display: flex;
        justify-content: center;
    }
    .btn-primary {
        background-color: #DC7C41; /* Oranye */
        border-color: #DC7C41;
        border-radius: 30px;
    }
    .btn-primary:hover {
        background-color: #e69500;
        border-color: #e69500;
    }
    .list-group-item strong {
        width: 150px; /* Atur lebar label agar sama */
        text-align: left;
    }
    .list-group-item span{
        text-align: left;
    }
    .list-group-item p {
        margin-bottom: 0;
    }
    .center-text {
        text-align: center;
        width: 100%;
    }
</style>

<div class="container invoice-container">
    <div class="invoice-title">
        Invoice
    </div>
    <div class="card invoice-card">
        <div class="card-body invoice-body" id="invoiceContent">
            <ul class="list-group list-group-flush">
            <li class="list-group-item">
                    <strong>No Invoice</strong> 
                </li>
                <li class="list-group-items text-center"><strong>{{ $reservation->id }}</strong></li>
                <li class="list-group-items text-center">
                    <p>Ordered By</p>
                </li>
                <li class="list-group-items ">
                    <strong>  {{ $reservation->user->name }}</strong> 
                </li>
              
                <li class="list-group-item">
                    <strong>Cafe</strong> 
                    <span>{{ $reservation->cafe->name }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Date</strong> 
                    <span>{{ $reservation->reservation_date }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Time</strong> 
                    <span>{{ $reservation->reservation_time }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Number Of Table</strong> 
                    <span>{{ $reservation->table_number }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Additional</strong> 
                    <span>{{ $reservation->package->name }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Total Invoice</strong> 
                    <span>Rp {{ number_format($reservation->final_total, 2, ',', '.') }},-</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-footer text-center">
            <button class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
        </div>
</div>

<script>
    function printInvoice() {
        var printContent = document.getElementById('invoiceContent').innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();

        document.body.innerHTML = originalContent;
    }
</script>
@endsection
