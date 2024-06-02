@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #f4f4f4; /* Light grey background for soft contrast */
        padding:  0 !important;
    }
    .container-fluid{
        padding: 0 !important;
    }
    .container {
        font-family: 'Roboto', sans-serif;
        color: #333; /* Dark grey text color for readability */
        margin-top: 20px;
    }

    h1 {
        font-weight: 700;
        color: #5B3708; /* Deep chocolate brown color for headings */
    }

    .card {
        border: none; /* No borders for a cleaner, modern look */
        border-radius: 15px; /* Slightly rounded corners for a softer appearance */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Subtle shadow for depth */
        transition: transform 0.3s ease-in-out; /* Smooth transition for hover effect */
    }

    .card:hover {
        transform: translateY(-5px); /* Lift card slightly on hover */
    }

    .card-header {
        font-size: 20px;
        font-weight: 500;
        background-color: #D19F63; /* Golden brown color for headers */
        color: #fff; /* White text color for better contrast */
        border-radius: 15px 15px 0 0; /* Rounded top corners */
    }

    .card-body h5 {
        font-size: 28px;
        font-weight: bold;
        color: #5B3708; /* Deep chocolate color for titles */
    }

    .card-text {
        font-size: 16px;
        color: #555; /* Darker text color for better readability */
    }
</style>

<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Jumlah Pengguna</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount }}</h5>
                    <p class="card-text">Total pengguna terdaftar.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Jumlah Kafe</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $cafeCount }}</h5>
                    <p class="card-text">Jumlah total kafe.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Reservasi Aktif</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $reservationCount }}</h5>
                    <p class="card-text">Total reservasi aktif.</p>
                </div>
            </div>
        </div>

        <!-- Optional: Chart -->
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <canvas id="dashboardChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('dashboardChart').getContext('2d');
    var dashboardChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Registrations',
                data: [10, 20, 30, 40, 35, 50],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
