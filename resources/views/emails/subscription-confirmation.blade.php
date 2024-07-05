<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Subscription</title>
</head>
<body>
    <h1>Confirm Your Subscription</h1>
    <p>Thank you for subscribing to our daily weather updates for {{ $subscriber->city }}.</p>
    <p>Please click the link below to confirm your email address:</p>
    <a href="{{ $verificationUrl }}">Confirm Email</a>
</body>
</html>
