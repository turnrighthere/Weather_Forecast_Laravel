<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">
        <h1>Weather Dashboard</h1>
        <form action="/weather" method="GET">
            <input type="text" name="city" id="city" placeholder="E.g, New York, London, Tokyo" required>
            <button type="submit">Search</button>
        </form>
        
        <!-- temp and day info -->
        <div id="weather-info">
            <section class="current-weather">
                <div class="container">
                    <div class="row">
                        <h2>Weather in {{ $weatherData['location']['name'] }}, {{ $weatherData['location']['country'] }}</h2>
                        <h2 id="current-day">Today</h2>
                        <h3 class="col temp-title" id="current-temperature"> {{ $weatherData['current']['temp_c'] }}°C</h3>
                        <div class="col d-flex align-items-center side-info">
                            <ul>
                                <p><img src="https:{{ $weatherData['current']['condition']['icon'] }}" alt="{{ $weatherData['current']['condition']['text'] }}"></p>
                                @isset($weatherData)
                                <p><strong></strong> {{ $weatherData['current']['condition']['text'] }}</p>
                                <p><strong>Humidity:</strong> {{ $weatherData['current']['humidity'] }}%</p>
                                <p><strong>Wind:</strong> {{ $weatherData['current']['wind_kph'] }} kph ({{ $weatherData['current']['wind_dir'] }})</p>
                            </ul>
                        </div>
                        @endisset
                    </div>
                </div>
                <hr />
            </section>
            @isset($error)
                <p>Error {{ $error }}: {{ $message }}</p>
            @endisset
        </div>
        <!-- 4 day forecast -->
        <section class="container">
            <div class="row week-forecast">
                @isset($weatherDataForecast)
                @foreach($weatherDataForecast as $dayForecast)
                <div class="col">
                    <h3>{{ $dayForecast['day_name'] }}</h3>
                    <br />
                    <img src="https:{{ $dayForecast['icon'] }}" alt="{{ $dayForecast['condition'] }}"/><br />
                    <p class="weather">{{ $dayForecast['condition'] }}</p>
                    <span>{{ $dayForecast['temp_c'] }}°C</span>
                </div>
                @endforeach
                @endisset
            </div>
        </section>
        <!-- Subscription Form -->
        <form action="/subscribe" method="POST">
            @csrf
            <input type="email" name="email" id="email" placeholder="E.g, hello@gmail.com" required>
            <input type="hidden" name="city" value="{{ $weatherData['location']['name'] }}">
            <button type="submit">Subscribe</button>
        </form>
    </div>
</body>
</html>