@extends('layouts.admin')

@section('content')
<!-- Ensure Bootstrap Icons are loaded -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2" style="color: #5B3708;">Cafe List</h1>
        <a href="{{ route('admin.cafes.create') }}" class="btn btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Add New Cafe
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cafes as $cafe)
                <tr>
                    <td>{{ $cafe->name }}</td>
                    <td>{{ $cafe->location }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.tables.index', $cafe->id) }}" class="btn btn-secondary">Manage Tables</a>
                        <a href="{{ route('admin.cafes.edit', $cafe->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-secondary" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this cafe?')) document.getElementById('delete-form-{{ $cafe->id }}').submit();">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                        <form id="delete-form-{{ $cafe->id }}" action="{{ route('admin.cafes.destroy', $cafe->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<style>
    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 15px;
        width: 100%;
    }

    .table th, .table td {
        padding: 15px;
        background-color: #fff;
        border: none;
        vertical-align: middle;
    }

    .table thead th {
        background-color: #6D4C41;
        color: #fff;
        font-size: 16px;
    }

    .table tr:first-child th:first-child {
        border-top-left-radius: 10px;
    }

    .table tr:first-child th:last-child {
        border-top-right-radius: 10px;
    }

    .table tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }

    .table tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }

    .btn-outline-primary {
        color: #6D4C41 !important;
        border-color: #6D4C41 !important;
        border-radius: 50px !important;
    }

    .btn-outline-primary:hover {
        background-color: #6D4C41 !important;
        color: #ffffff !important;
    }

    .btn-outline-secondary {
        color: #6D4C41 !important;
        border-color: #6D4C41 !important;
    }

    .btn-outline-secondary:hover {
        background-color: #6D4C41 !important;
        color: #ffffff !important;
    }

    i.bi {
        font-size: 1.2rem;
    }
</style>
