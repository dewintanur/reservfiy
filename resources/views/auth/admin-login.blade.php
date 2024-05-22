<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Reservfiy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sora', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('path-to-your-background-image.jpg') no-repeat center center fixed; 
            background-size: cover;
        }

        .container {
            background: rgba(255, 255, 255, 0.85); /* Semi-transparent white background */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            width: 350px;
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.7);
        }

        button.login-2 {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #6D4C41; /* Chocolate color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.login-2:hover {
            background-color: #5B3708; /* Darker chocolate color */
        }

        .login-1 {
            margin-bottom: 20px;
            color: #6D4C41; /* Chocolate color for heading */
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="login">
    <div class="container">
        <div class="login-1">Admin Login</div>
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="username">
                <input type="text" name="username" placeholder="Enter your username" required autofocus>
            </div>
            <div class="password">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="loginbar">
                <button type="submit" class="login-2">Login</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
