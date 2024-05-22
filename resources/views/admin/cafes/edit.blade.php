@extends('layouts.admin')

@section('content')
<!-- Ensure Bootstrap Icons are loaded -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container my-4"
    style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
    <h1 class="mb-4" style="color: #5B3708;">Edit Cafe</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.cafes.update', $cafe->id) }}" method="POST" enctype="multipart/form-data"
        class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name">Cafe Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $cafe->name) }}"
                    required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location"
                    value="{{ old('location', $cafe->location) }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"
                rows="3">{{ old('description', $cafe->description) }}</textarea>
        </div>

        <h5>Operational Hours</h5>
        <div id="time_periods" class="mb-3">
            <!-- Time periods will be added here dynamically based on existing data -->
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addTimePeriod()">Add Time
            Period</button>

        <div class="mb-3">
            <label for="maps_link">Google Maps Link:</label>
            <input type="text" name="maps_link" id="maps_link" class="form-control"
                value="{{ old('maps_link', $cafe->maps_link) }}">
        </div>
        <div class="mb-3">
            <label for="photo">Upload Photo:</label>
            <input type="file" name="photo" id="photo" class="form-control-file">
            @if ($cafe->photo)
                Current: <a href="{{ asset('storage/' . $cafe->photo) }}" target="_blank">View Current Photo</a>
            @endif
        </div>
        <div class="mb-3">
            <label for="menu">Upload Menu:</label>
            <input type="file" name="menu" id="menu" class="form-control-file">
            @if ($cafe->menu)
                Current: <a href="{{ asset('storage/' . $cafe->menu) }}" target="_blank">View Current Menu</a>
            @endif
        </div>
        <div class="mb-3">
            <label for="rating">Rating:</label>
            <input type="number" name="rating" id="rating" class="form-control"
                value="{{ old('rating', $cafe->rating) }}" step="0.1" min="0" max="5">
        </div>
        <div class="mb-3">
            <label for="social_media">Social Media Links:</label>
            <input type="text" name="social_media" id="social_media" class="form-control"
                value="{{ old('social_media', $cafe->social_media) }}">
        </div>
        <div class="mb-3">
            @foreach($categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="categories[]" id="category_{{ $category->id }}"
                        value="{{ $category->id }}" {{ in_array($category->id, $cafe->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <h5 class="mt-4">Edit Packages</h5>
        <div id="packages_container">
            <!-- Packages will be dynamically added here -->
        </div>
        <button type="button" id="add-package-button" class="btn btn-outline-secondary btn-sm">Add Package</button>

        <button type="submit" class="btn btn-primary btn-content">Update</button>
    </form>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeTimePeriods();
        initializePackages();
        document.getElementById('add-package-button').addEventListener('click', function() {
            addPackage();
        });
    });

    function addPackage(name = '', description = '', price = '') {
        var container = document.getElementById('packages_container');
        var count = container.children.length;
        var newPackage = document.createElement('div');
        newPackage.classList.add('input-group', 'mb-3');
        newPackage.innerHTML = `
            <input type="text" name="packages[${count}][name]" class="form-control" placeholder="Package Name" value="${name}" required>
            <textarea name="packages[${count}][description]" class="form-control" placeholder="Description">${description}</textarea>
            <input type="number" name="packages[${count}][price]" class="form-control" placeholder="Price" value="${price}" required>
            <button type="button" class="btn btn-danger" onclick="removePackage(this)">Remove</button>
        `;
        container.appendChild(newPackage);
    }

    function removePackage(button) {
        button.parentNode.remove();
        document.querySelectorAll('#packages_container .input-group').forEach((group, index) => {
            group.querySelector('input[type="text"]').name = `packages[${index}][name]`;
            group.querySelector('textarea').name = `packages[${index}][description]`;
            group.querySelector('input[type="number"]').name = `packages[${index}][price]`;
        });
    }

    function addTimePeriod(day = '', open_time = '', close_time = '') {
        var container = document.getElementById('time_periods');
        var count = container.children.length;
        var newTimePeriod = document.createElement('div');
        newTimePeriod.classList.add('input-group', 'mb-3');
        newTimePeriod.innerHTML = `
            <select name="day[${count}]" class="form-control">
                <option value="Monday" ${day === 'Monday' ? 'selected' : ''}>Monday</option>
                <option value="Tuesday" ${day === 'Tuesday' ? 'selected' : ''}>Tuesday</option>
                <option value="Wednesday" ${day === 'Wednesday' ? 'selected' : ''}>Wednesday</option>
                <option value="Thursday" ${day === 'Thursday' ? 'selected' : ''}>Thursday</option>
                <option value="Friday" ${day === 'Friday' ? 'selected' : ''}>Friday</option>
                <option value="Saturday" ${day === 'Saturday' ? 'selected' : ''}>Saturday</option>
                <option value="Sunday" ${day === 'Sunday' ? 'selected' : ''}>Sunday</option>
            </select>
            <input type="time" name="open_time[${count}]" class="form-control" value="${open_time}">
            to
            <input type="time" name="close_time[${count}]" class="form-control" value="${close_time}">
            <button type="button" class="btn btn-danger" onclick="removeTimePeriod(this)">Remove</button>
        `;
        container.appendChild(newTimePeriod);
    }

    function removeTimePeriod(button) {
        button.parentNode.remove();
        document.querySelectorAll('#time_periods .input-group').forEach((group, index) => {
            group.querySelector('select').name = `day[${index}]`;
            group.querySelector('input[type="time"]:nth-child(2)').name = `open_time[${index}]`;
            group.querySelector('input[type="time"]:nth-child(4)').name = `close_time[${index}]`;
        });
    }

    function initializeTimePeriods() {
        @php
            $hours = json_decode($cafe->operational_hours, true) ?? [];
        @endphp

        @if(is_array($hours))
            @foreach($hours as $index => $period)
                addTimePeriod('{{ $period['day'] ?? 'Monday' }}', '{{ date("H:i", strtotime($period['open'])) }}', '{{ date("H:i", strtotime($period['close'])) }}');
            @endforeach
        @endif
    }
    function initializePackages() {
        @php
            $packages = $cafe->packages ?? [];
        @endphp

        @foreach($packages as $package)
            addPackage('{{ $package->name }}', '{{ $package->description }}', '{{ $package->price }}');
        @endforeach
    }
</script>
