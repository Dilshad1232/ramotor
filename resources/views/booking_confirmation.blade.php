@extends('homelayouts.app')
@section('title', 'Booking Confirmed')

@section('content')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f5f5f5;">

    <div class="card shadow-lg p-4" style="max-width: 500px; width:100%; border-radius: 16px; border-top: 6px solid #D81324;">

        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#D81324;">Booking Confirmed!</h2>
            <p class="text-muted mb-0">Thank you, <strong>{{ $booking->name }}</strong></p>
        </div>

        <!-- Booking Details -->
        <div class="p-3 mb-4 rounded-3" style="background-color: #fff; border-left: 5px solid #D81324; box-shadow: 0 2px 10px rgba(216,19,36,0.1);">
            <p class="mb-2"><strong>Service:</strong> {{ $booking->service }}</p>
            <p class="mb-2"><strong>Date:</strong> {{ $booking->service_date }}</p>
            <p class="mb-2"><strong>Phone:</strong> {{ $booking->phone }}</p>
            <p class="mb-2"><strong>Email:</strong> {{ $booking->email }}</p>
            <p class="mb-2"><strong>Address:</strong> {{ $booking->address }}</p>
            <p class="mb-2"><strong>Payment Status:</strong> <span style="color: {{ $booking->payment_status == 'paid' ? '#28a745' : '#D81324' }};">{{ ucfirst($booking->payment_status) }}</span></p>
        </div>

        <!-- Download Receipt Button -->
        <div class="text-center">
            <a href="{{ route('booking.receipt', $booking->id) }}" class="btn btn-lg" style="background-color:#D81324; color:#fff; font-weight:bold; border-radius:10px; box-shadow: 0 4px 12px rgba(216,19,36,0.4); transition: all 0.3s ease;">
                Download Receipt
            </a>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-3">
            <small class="text-muted">📄 Keep this receipt for your records</small>
        </div>

    </div>

</div>

@endsection
