<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <h2>Booking Details</h2>
    <p>A new booking has been created/updated:</p>
    <ul>
        <li>Booking ID: {{ $booking->id }}</li>
        <li>Name: {{ $booking->first_name }} {{ $booking->last_name }}</li>
        <li>Email: {{ $booking->email }}</li>
        <li>Phone Number: {{ $booking->phone_number }}</li>
        <!-- Add more booking details here as needed -->
    </ul>
</body>

</html>
