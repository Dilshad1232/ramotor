<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Hello {{ $booking->name }},</h2>
    <p>Your booking has been confirmed for <strong>{{ $booking->service }}</strong> on <strong>{{ $booking->service_date }}</strong>.</p>
    <p>We will contact you on <strong>{{ $booking->phone }}</strong> if needed.</p>
    <p>Thank you for choosing Indian Color Point!</p>
</body>
</html>
