<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #EDE7F6; /* Mauve background color */
            color: #333333; /* Dark text color */
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            text-align: center;
            padding: 20px;
            background-image: url('/images/bg4.png'); /* Background image for the top quarter */
            background-size: cover;
            background-position: center;
            height: 25vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header a {
            margin: 0 10px;
            color: #FFFFFF; /* White text color */
            text-decoration: none;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for buttons */
            padding: 10px 20px;
            border-radius: 5px;
        }
        .header a:hover {
            background-color: rgba(0, 0, 0, 0.7); /* Darker semi-transparent background on hover */
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .title {
            font-size: 2.5rem;
            color: #333333; /* Dark text color */
            margin-top: 20px;
        }
        .subtitle {
            font-size: 1.25rem;
            color: #666666; /* Medium dark text color */
            margin-top: 10px;
        }
        .cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background-color: #FFF9C4; /* Cream card background */
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 0px;
            text-align: center;
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .button {
            background-color: #B3C7E6; /* Blue button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }
        .button:hover {
            background-color: #4A90E2; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <header class="header">
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="button">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button">Admin Log in</a>
                  
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="button">Register</a>
                    
                    @endif
                @endauth
            </div>
        @endif
    </header>
    <div class="container">
        <h1 class="title">Welcome to MathTrek </h1>
        <p class="subtitle">Bringing innovation and excellence to education</p>
        <div class="cards">
            <!-- <div class="card">
                <img src="/images/logoMath.jpeg" alt="Ad Image 1">
            </div> -->
            <div class="card">
                <!-- <h2>Ad Image 2</h2> -->
                <img src="/images/logoMath.jpeg" alt="Ad Image 2">
            </div>
            <!-- <div class="card">
                <img src="/images/logoMath.jpeg" alt="Ad Image 3">
            </div> -->
        </div>
    </div>
    <footer class="footer">
        <!-- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) -->
    </footer>
</body>
</html>
