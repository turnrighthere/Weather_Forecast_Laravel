<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <h1>Weather Dashboard</h1>
        <form action="/weather" method="GET">
            <input type="text" name="city" id="city" placeholder="E.g, New York, London, Tokyo" required>
            <button type="submit">Search</button>
        </form>
        <div id="weather-info"></div>
    </div>
</body>
</html>