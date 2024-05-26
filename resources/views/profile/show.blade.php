@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

<div class="container-fluid p-5 profile">
    <div class="sidebar p-3">
        <div class="user-profile mb-2 fs-4 fw-bold" style="font-size:30px">User Profile</div>
        <div class="user-info mb-2">
            <a href="{{ route('profile.show') }}" class="nav-link">User Info</a>
        </div>
        <div class="riwayat-pesanan mb-2">
            <a href="{{ route('reservations.index', ['user' => $user->id]) }}" class="nav-link">Riwayat Pesanan</a>
        </div>
        <div class="mt-auto d-flex align-items-center justify-content-center">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-danger">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>

    <div class="line-15 my-3"></div>

    <div class="profile-content">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            @method('PUT')
            <div class="container-11 mb-3 d-flex align-items-center">
                <div class="position-relative me-2 photo-container">
                    @if ($user->photo)
                        <img src="{{ Storage::url('public/profil/' . $user->photo) }}" class="rounded-circle photo"
                            alt="Profile Photo" width="90" height="90">
                    @else
                        <img src="{{ asset('assets/images/default-profile.png') }}" class="rounded-circle photo"
                            alt="Default Profile Photo" width="113" height="113">
                    @endif
                    <label for="photo"
                        class="position-absolute top-0 start-0 translate-middle p-2 bg-primary text-white rounded-circle photo-label"
                        style="cursor: pointer;">
                        <i class="bi bi-pencil-fill"></i>
                        <input type="file" id="photo" name="photo" class="d-none">
                    </label>
                </div>
                <div>
                    <div class="hello-delwyn mb-1">Hello, {{ $user->name }}</div>
                    <span class="malang">{{ $user->alamat }}</span>
                </div>
            </div>
            <div class="user-details">
                <div class="d-flex flex-wrap">
                    <div class="container-input mb-3 d-flex align-items-center me-3">
                        <label for="username" class="me-3 username">Username</label>
                        <input type="text" id="username" name="username" class="form-control delwyn-zevanna fw-bold"
                            value="{{ $user->name }}">
                    </div>
                    <div class="container-input mb-3 d-flex align-items-center">
                        <label for="password" class="me-3 password">Password</label>
                        <input type="password" id="password" name="password" class="form-control fw-bold"
                            placeholder="Enter new password if you want to change">
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <div class="container-input mb-3 d-flex align-items-center me-3">
                        <label for="email" class="me-3 email">Email</label>
                        <input type="email" id="email" name="email" class="form-control delwynnzvngmail-com fw-bold"
                            value="{{ $user->email }}">
                    </div>
                    <div class="container-input mb-3 d-flex align-items-center">
                        <label for="address" class="me-3 alamat">Alamat</label>
                        <input type="text" id="address" name="address" class="form-control dewandaru fw-bold"
                            value="{{ $user->alamat }}">
                    </div>
                </div>
                <div class=" text-end">
                    <button type="submit" class="fw-bold btn btn-danger">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .fw-bold {
        font-weight: bold;
    }

    .profile {
        display: flex;
        flex-direction: row;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .sidebar {
        flex: 0 0 250px;
        display: flex;
        flex-direction: column;
        padding: 20px;
        margin-right: 20px;
    }

    .form-control {
        background-color: #D9D9D9 !important;
    }

    .profile-content {
        flex: 1;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 10px;
    }

    .user-profile,
    .user-info,
    .riwayat-pesanan {
        font-family: 'Sora';
        font-size: 18px;
        color: #000000 !important;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .nav-link {
        color: inherit !important;
    }

    .line-15 {
        background: #000000;
        width: 1px;
        height: auto;
        margin-right: 20px;
    }

    .container-8,
    .container-2,
    .container-9,
    .container-5 {
        background: #D9D9D9;
        border-radius: 28px;
        padding: 10px 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .container-input {
        flex: 1;
        background: #D9D9D9;
        border-radius: 28px;
        padding: 10px 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    
    .container-4 {
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        border-radius: 28px;
        background: #D19F63;
        display: flex;
        justify-content: center;
        padding: 10px;
        width: 100%; /* Lebar tombol sama dengan elemen input */
    }

    .btn-danger {
        font-size: 50px;
        font-weight: 10px;
        color: #FFF;
        background-color: #D19F63 !important;
        border-color: #D19F63 !important;
        padding: 10px 35px;
        right: 0;
        border-radius: 20px !important;
        text-align: center;
        width: 48% !important;
    }

    .logout {
        font-size: 30px;
        font-weight: 200;
    }

    .update {
        color: #FFF;
        text-align: center;
        cursor: pointer;
    }

    .photo-container {
        position: relative;
    }

    .photo {
        object-fit: cover;
        border-radius: 50%;
    }

    .photo-label {
        display: none;
        align-items: center;
        justify-content: center;
    }

    .photo-container:hover .photo-label {
        display: flex;
    }

    .hello-delwyn,
    .malang,
    .username,
    .email,
    .password,
    .alamat,
    .dewandaru {
        font-family: 'Sora';
        color: #303336;
        justify-content: start;
    }

    label {
        flex: 0 0 150px;
        /* Adjust label width */
        text-align: left;
        margin-right: 10px;
    }
</style>
