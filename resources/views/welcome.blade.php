<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Employee Point System</title>

    {{-- Include your compiled CSS/JS (Bootstrap, your custom app.scss, etc.) --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Full-page gradient background */
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f2f2f2 0%, #e6e6e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-card {
            width: 420px;
            background-color: #fff;
            color: #333;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .welcome-card-title {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .welcome-card-subtitle {
            font-size: 1rem;
            color: #666;
        }

        .welcome-card .btn {
            min-width: 100px;
        }

        /* Hover effect for the buttons */
        .welcome-card .btn:hover {
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="card welcome-card">
        <div class="card-body text-center p-5">
            <h1 class="welcome-card-title mb-3">Employee Point System</h1>
            <p class="welcome-card-subtitle mb-4">
                Welcome! Please login or register to continue.
            </p>
            <div class="d-flex justify-content-around">
                <a href="{{ route('login') }}" class="btn btn-dark">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
