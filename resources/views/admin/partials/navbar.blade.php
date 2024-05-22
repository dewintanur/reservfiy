
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/reservfiy63.png') }}" alt="Admin Dashboard" style="height: 50px;">Admin Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cafes.index') }}">Manage Cafes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.reservations.index') }}">Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">Manage Categories</a>
                </li>
                <!-- More navigation items -->
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Assuming you have logout functionality -->
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-chocolate">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Additional CSS for customizing the navbar -->
<style>
    .navbar {
        background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
        backdrop-filter: blur(10px); /* Soft blur effect for underlying content */
        border-bottom: 2px solid rgba(93, 64, 55, 0.2); /* Semi-transparent border */
    }

    .navbar-toggler {
        border-color: rgba(188, 170, 164, 0.5); /* Light brown border for the toggler */
    }

    .navbar-toggler-icon {
        /* Customizing the toggle icon color */
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%236D4C41' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-brand {
        color: #5B3708 !important; /* Chocolate color for the brand text for high contrast */
        font-weight: bold;
    }

    .navbar-brand img {
        margin-right: 10px; /* Space between image and text */
    }

    .nav-link  {
        color: #5B3708 !important; /* Chocolate color for links */
        transition: color 0.3s ease-in-out; /* Smooth transition for hover */
    }

    .nav-link:hover, .nav-link:focus {
        color: #3E2723; /* Darker shade of chocolate on hover */
    }

    .btn-outline-chocolate {
        color: #5B3708 !important; /* Chocolate color for text */
        border-color: #5B3708 !important; /* Chocolate color for border */
        background-color: transparent !important; /* Clear background */
        border-radius: 100px !important; /* Fully rounded borders */
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 6px 12px; /* Adequate padding */
    }

    .btn-outline-chocolate:hover {
        background-color: #5B3708; /* Chocolate background on hover */
        color: #FFFFFF; /* White text on hover */
    }

    @media (max-width: 992px) {
        .navbar-collapse {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly more opaque for mobile */
        }
    }
</style>
