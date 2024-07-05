<!DOCTYPE html>
<html>
<head>
    <title>Subscribe to Weather Updates</title>
</head>
<body>
    <h1>Subscribe to Weather Updates</h1>

    <form action="{{ route('subscribe') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
        <button type="submit">Subscribe</button>
    </form>
</body>
</html>
