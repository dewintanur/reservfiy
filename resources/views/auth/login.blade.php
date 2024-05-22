<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Reservfiy</title>
    <link href="{{ asset('css/Login.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sora', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f0f0 !important;
            margin: 0;
            padding: 0;
        }
        .login {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            max-width: 100%;
            margin:0;
        }
     
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-1, .forgot-password, .new-here-register-here, .admin-login {
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #6D4C41; /* Link color */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
       
        .google {
            width: 300px!important;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
       
    </style>
</head>
<body>
<div class="login">
    <div class="reservfiy-61"></div> <!-- Make sure this div correctly includes your logo -->
    <div class="container">
        <h2 class="login-1">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="email">
                <input type="email" name="email" placeholder="Enter your email" required autofocus>
            </div>
            <div class="password">
                <input type="password" name="password" placeholder="Password" required>
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
            </div>
            <div class="loginbar">
                <button type="submit" class="login-2">Login</button>
            </div>
        </form>
        <div class="google">
            <img class="vector" src="{{ asset('vectors/vector46_x2.svg') }}" alt="Continue with Google" />
            <span class="continue-with-google">Continue with Google</span>
        </div>
        <div class="frame-3200">
            <span class="new-here-register-here">New here? <a href="{{ route('register') }}">Register here!</a></span>
        </div>
        <a href="{{ route('admin.login') }}" class="admin-login">Login as Admin</a>

    </div>
</div>
</body>
</html>
