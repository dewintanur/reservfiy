@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Manage Tables for {{ $cafe->name }}</h1>

    <div class="mb-4">
        <form action="{{ route('admin.tables.store', $cafe->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="table_number">Table Number</label>
                <input type="number" class="form-control" id="table_number" name="table_number" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Table</button>
        </form>
    </div>

    <h2>Existing Tables</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Table Number</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tables as $table)
            <tr>
                <td>{{ $table->id }}</td>
                <td>{{ $table->table_number }}</td>
                <td>{{ $table->capacity }}</td>
                <td>{{ $table->status }}</td>
                <td>
                    <!-- Actions like edit or delete can be added here -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
