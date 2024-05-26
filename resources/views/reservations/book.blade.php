@extends('layouts.app')

@section('title', 'Book a Cafe')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .btn-brown {
        background-color: #8B4513;
        /* Dark brown color */
        color: white;
    }

    .btn-brown:hover {
        background-color: #A0522D;
        /* Lighter brown color */
    }
</style>
<div class="container mt-5">
    <div class="shadow p-4 rounded bg-white">
        <h1 class="mb-4">{{ $cafe->name }}</h1>
        <form action="{{ route('reservations.store', $cafe->id) }}" method="POST" class="p-4 rounded">
            @csrf
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-2">
                    <label for="reservation_date" class="form-label">Pick a Date</label>
                </div>
                <div class="col-md">
                    <div class="input-group ">
                        <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
                        <span class="input-group-text "><i class="bi bi-calendar3"></i></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="reservation_time" class="form-label">Pick a Time</label>
                </div>
                <div class="col-md">
                    <div class="input-group">
                        <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-2">
                    <label for="table_number" class="form-label">Pick a Table</label>
                </div>
                <div class="col">
                    <div class="input-group">
                        <select class="form-control" id="table_id" name="table_id" required>
                        <option value="">Choose Number Of Person First</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ $table->capacity }}
                                    person)</option>
                            @endforeach
                            @foreach($tables as $table)
                                <input type="hidden" name="table_number" value="{{ $table->table_number }}">
                            @endforeach

                        </select>
                        <span class="input-group-text"><i class="bi bi-table"></i></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="number_of_people" class="form-label">Number of People</label>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="number" class="form-control" id="number_of_people" name="number_of_people" required
                            min="1">
                        <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">Additional</h4>
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-2">
                    <label for="food_selection">Packages</label>
                </div>
                <div class="col">
                    <div class="input-group">
                        <select class="form-control" id="package_id" name="package_id">
                            <option value="">Choose The Package</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }} -
                                    Rp{{ number_format($package->price, 2) }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text"><i class="bi bi-basket"></i></span>
                    </div>
                </div>
                <!-- <div class="col-md-2">
                    <label for="drink_selection">Drink Selection</label>
                </div>
                <div class="col">
                    <div class="input-group">
                        <select class="form-control" id="drink_selection" name="drink_selection">
                            <option value="">Select Drink</option>
                            <option value="Drink 1">Drink 1</option>
                            <option value="Drink 2">Drink 2</option>
                        </select>
                        <span class="input-group-text"><i class="bi bi-cup-straw"></i></span>
                    </div>
                </div> -->
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-brown">Book Now</button>
            </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#number_of_people').on('change', function () {
            var capacity = $(this).val();
            var cafeId = "{{ $cafe->id }}";

            $.ajax({
                url: '{{ route('reservations.getTablesByCapacity') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    capacity: capacity,
                    cafe_id: cafeId
                },
                success: function (data) {
                    console.log('Tables data:', data); // Tambahkan log ini
                    $('#table_id').empty();
                    $.each(data, function (index, table) {
                        $('#table_id').append('<option value="' + table.id + '">Table ' + table.table_number + ' (' + table.capacity + ' person)</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error); // Tambahkan log ini
                }
            });
        });
    });
</script>
@endsection