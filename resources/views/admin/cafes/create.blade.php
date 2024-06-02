@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Cafe</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.cafes.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name">Cafe Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <h5>Operational Hours</h5>
        <div id="time_periods" class="mb-3">
            <!-- Time periods will be added here dynamically -->
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addTimePeriod()">Add Time Period</button>

        <div class="mb-3">
            <label for="maps_link">Google Maps Link:</label>
            <input type="text" name="maps_link" id="maps_link" class="form-control">
        </div>
        <div class="mb-3">
            <label for="photo">Upload Photo:</label>
            <input type="file" name="photo" id="photo" class="form-control-file">
        </div>
        <div class="mb-3">
            <label for="menu">Upload Menu:</label>
            <input type="file" name="menu" id="menu" class="form-control-file">
        </div>
        <div class="mb-3">
            <label for="rating">Rating:</label>
            <input type="number" name="rating" id="rating" class="form-control" step="0.1" min="0" max="5">
        </div>
        <div class="mb-3">
            <label for="social_media">Social Media Links:</label>
            <input type="text" name="social_media" id="social_media" class="form-control">
        </div>
        <div class="mb-3">
            @foreach($categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}">
                    <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>

        <!-- Packages Section -->
        <div class="mb-3">
            <h5>Packages</h5>
            <div id="packages">
                <!-- Packages will be added here dynamically -->
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addPackage()">Add Package</button>
        </div>
          <!-- Tables Section -->
          <!-- <div class="mb-3">
            <h5>Tables</h5>
            <div id="tables"> -->
                <!-- Tables will be added here dynamically -->
            <!-- </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addTable()">Add Table</button>
        </div> -->

        <button type="submit" class="btn btn-primary btn-content">Save</button>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    addTimePeriod(); // Initially add one time period
    addPackage(); // Initially add one package
});

function addTimePeriod() {
    var container = document.getElementById('time_periods');
    var count = container.children.length;  // Count existing time period entries
    var newTimePeriod = document.createElement('div');
    newTimePeriod.classList.add('input-group', 'mb-3');
    newTimePeriod.innerHTML = `
        <select name="day[${count}]" class="form-control">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
        </select>
        <input type="time" name="open_time[${count}]" class="form-control">
        to
        <input type="time" name="close_time[${count}]" class="form-control">
        <button type="button" class="btn btn-danger" onclick="removeTimePeriod(this)">Remove</button>
    `;
    container.appendChild(newTimePeriod);
}

function removeTimePeriod(button) {
    button.parentNode.remove();
    // After removal, re-index all elements
    document.querySelectorAll('#time_periods .input-group').forEach((group, index) => {
        group.querySelector('select').name = `day[${index}]`;
        group.querySelector('input[type="time"]:nth-child(2)').name = `open_time[${index}]`;
        group.querySelector('input[type="time"]:nth-child(4)').name = `close_time[${index}]`;
    });
}

function addPackage() {
    var container = document.getElementById('packages');
    var count = container.children.length;  // Count existing package entries
    var newPackage = document.createElement('div');
    newPackage.classList.add('input-group', 'mb-3');
    newPackage.innerHTML = `
        <input type="text" name="packages[${count}][name]" class="form-control" placeholder="Package Name">
        <input type="number" name="packages[${count}][price]" class="form-control" placeholder="Price" step="0.01" min="0">
        <textarea name="packages[${count}][description]" class="form-control" placeholder="Description"></textarea>
        <button type="button" class="btn btn-danger" onclick="removePackage(this)">Remove</button>
    `;
    container.appendChild(newPackage);
}

function removePackage(button) {
    button.parentNode.remove();
    // After removal, re-index all elements
    document.querySelectorAll('#packages .input-group').forEach((group, index) => {
        group.querySelector('input[type="text"]').name = `packages[${index}][name]`;
        group.querySelector('input[type="number"]').name = `packages[${index}][price]`;
        group.querySelector('textarea').name = `packages[${index}][description]`;
    });
}
function addTable() {
    var container = document.getElementById('tables');
    var count = container.children.length;  // Count existing table entries
    var newTable = document.createElement('div');
    newTable.classList.add('input-group', 'mb-3');
    newTable.innerHTML = `
        <input type="number" name="tables[${count}][table_number]" class="form-control" placeholder="Table Number">
        <input type="number" name="tables[${count}][capacity]" class="form-control" placeholder="Capacity" min="1">
        <select name="tables[${count}][status]" class="form-control">
            <option value="available">Available</option>
            <option value="reserved">Reserved</option>
        </select>
        <button type="button" class="btn btn-danger" onclick="removeTable(this)">Remove</button>
    `;
    container.appendChild(newTable);
}

function removeTable(button) {
    button.parentNode.remove();
    // After removal, re-index all elements
    document.querySelectorAll('#tables .input-group').forEach((group, index) => {
        group.querySelector('input[type="number"]').name = `tables[${index}][table_number]`;
        group.querySelector('input[type="number"]').name = `tables[${index}][capacity]`;
        group.querySelector('select').name = `tables[${index}][status]`;
    });
}
</script>

<style>
/* Base settings for body and container */
body {
    background-color: #f4f7fa;  /* Light grey background for the whole page */
    font-family: 'Arial', sans-serif;
}

.container {
    max-width: 900px;  /* Restricts the container's max width for better readability */
    margin: 40px auto; /* Centers the container with margin */
    padding: 25px;     /* Padding inside the container */
    background-color: #ffffff; /* White background for the container */
    border-radius: 12px; /* Rounded corners */
    box-shadow: 0 0 15px rgba(0,0,0,0.1); /* Subtle shadow for 3D effect */
}

/* Header styles */
h1 {
    color: #333; /* Dark grey color for the heading */
    margin-bottom: 20px; /* Spacing below the heading */
    text-align: center; /* Center-align the heading */
}

/* Styling form elements */
.form-group, .mb-3 {
    margin-bottom: 20px; /* Spacing below each form group */
}

label {
    display: block; /* Ensures the label takes the full width */
    color: #555; /* Dark grey color for text */
    margin-bottom: 8px; /* Spacing below each label */
    font-weight: bold; /* Makes font bold */
}

input[type="text"], 
input[type="number"], 
input[type="file"], 
textarea, 
select {
    width: 100%; /* Full width */
    padding: 10px; /* Padding inside the input fields */
    border: 1px solid #ccc; /* Subtle border */
    border-radius: 4px; /* Rounded borders */
    box-sizing: border-box; /* Includes padding and border in the element's width */
}

textarea {
    height: auto; /* Auto-height based on content */
    min-height: 100px; /* Minimum height */
}

input[type="file"] {
    background-color: #eef1f4; /* Slightly off white background */
    border: none; /* Removes border */
}

/* Button styling */
.btn-content, .btn {
    color: white; /* White text */
    background-color: #5C67F2; /* Slightly deep blue */
    border: none; /* No border */
    padding: 10px 20px; /* Padding inside the button */
    border-radius: 5px; /* Rounded borders */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s; /* Smooth transition for hover effects */
}

.btn-content:hover, .btn:hover {
    background-color: #4a54e1; /* A shade darker on hover */
}

/* Specific styles for alert boxes */
.alert-danger {
    color: #721c24; /* Dark red text for danger */
    background-color: #f8d7da; /* Light red background */
    border-color: #f5c6cb; /* Light red border */
    padding: 10px; /* Padding inside the alert box */
    border-radius: 4px; /* Rounded corners for the alert box */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 15px; /* Lesser padding on smaller screens */
    }

    .form-group, .mb-3 {
        margin-bottom: 15px; /* Lesser margin on smaller screens */
    }
}
</style>
