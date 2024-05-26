    <!-- Navbar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <nav class="navbar navbar-expand-md navbar-light bg-brown shadow-sm">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/reservfiy72.png') }}" alt="Logo" style="height: 40px;">
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar links and items -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav bg-transparant">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('cafes.index') }}">Cafes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('reservations.index') }}">Reservations</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="badge bg-danger notif-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li class="dropdown-item">{{ $notification->data['message'] }}</li>
                                @empty
                                    <li class="dropdown-item">No new notifications</li>
                                @endforelse
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        @auth
        function checkNotifications() {
            $.ajax({
                url: "{{ route('notifications.check') }}",
                type: "GET",
                success: function(data) {
                    if (data.count > 0) {
                        $('.notif-count').text(data.count).show();
                        var notifications = "";
                        data.notifications.forEach(function(notification) {
                            notifications += '<li class="dropdown-item">' + notification.message + '</li>';
                        });
                        $('.dropdown-menu').html(notifications);
                    } else {
                        $('.notif-count').hide();
                    }
                }
            });
        }

        $(document).ready(function() {
            checkNotifications();
            setInterval(checkNotifications, 30000);

            $('#notificationDropdown').on('show.bs.dropdown', function() {
                $.ajax({
                    url: "{{ route('notifications.markAsRead') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        $('.notif-count').text(0).hide();
                    }
                });
            });
        });
        @endauth
    </script>

    <!-- Custom CSS -->
    <style>
    .nav-link.text-white {
        color: #5B3708 !important;
    }
    .nav-item {
        position: relative;
    }

    .notif-count {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 12px;
        display: none; /* Sembunyikan secara default */
    }
    </style>
