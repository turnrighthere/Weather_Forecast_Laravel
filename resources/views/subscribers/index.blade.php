<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">
        <h1>Subscribers List</h1>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>City</th>
                    <th>Subscribed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ $subscriber->city }}</td>
                    <td>{{ $subscriber->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
