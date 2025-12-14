<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-left: 6px solid #D81324;
        }

        /* Logo & Header */
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            color: #D81324;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #555;
            margin-top: 5px;
            font-size: 14px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td {
            color: #333;
        }

        /* Amount Box */
        .amount-box {
            margin-top: 25px;
            padding: 18px;
            background-color: #ffe5e5;
            border-left: 6px solid #D81324;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .amount-box strong {
            font-size: 18px;
            color: #D81324;
        }
        .amount-box span {
            font-size: 22px;
            font-weight: bold;
            color: #D81324;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Logo -->
    <div class="logo">
        {{-- <img src="{{ public_path('img/logo2 .png') }}" alt="Company Logo"> --}}
    </div>

    <!-- Header -->
    <div class="header">
        <h2>Booking Receipt</h2>
        <p>Indian Color Point & Autoglass</p>
    </div>

    <!-- Booking Details -->
    <table>
        <tr><th>Name</th><td>{{ $booking->name }}</td></tr>
        <tr><th>Email</th><td>{{ $booking->email }}</td></tr>
        <tr><th>Service</th><td>{{ $booking->service }}</td></tr>
        <tr><th>Service Date</th><td>{{ $booking->service_date }}</td></tr>
        <tr><th>Phone</th><td>{{ $booking->phone }}</td></tr>
        <tr><th>Address</th><td>{{ $booking->address }}</td></tr>
        <tr><th>Payment Status</th><td>{{ $booking->payment_status ?? 'Pending' }}</td></tr>
    </table>

    <!-- Amount Paid -->
    <div class="amount-box">
        <strong>Amount Paid</strong>
        <span>₹{{ $booking->amount ?? 100 }}</span>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your payment. This is a computer generated receipt and does not require a signature.</p>
        <p>Contact: +91 9793145874 | Email: info@indiancolorpoint.com</p>
        <p>Website: www.indiancolorpoint.com</p>
    </div>
</div>
</body>
</html>
