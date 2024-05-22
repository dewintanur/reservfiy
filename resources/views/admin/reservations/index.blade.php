@extends('layouts.admin')

@section('title', 'Manage Reservations')

@section('content')
<div class="container mt-4">
    <h1>Manage Reservations</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Cafe</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->cafe->name }}</td>
                <td>{{ $reservation->date }}</td>
                <td>{{ $reservation->time }}</td>
                <td>{{ $reservation->status }}</td>
                <td>
                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
