@extends('homelayouts.app')
@section('title', 'Payment')

@section('content')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f5f5f5;">

    <div class="card shadow-lg p-4" style="max-width: 480px; width:100%; border-radius: 16px; border-top: 6px solid #D81324;">

        <!-- Header -->
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color:#D81324;">Secure Payment</h3>
            <p class="text-muted mb-0">Pay for your booking, <strong>{{ $booking->name }}</strong></p>
        </div>

        <!-- Booking Info -->
        <div class="p-3 mb-4 rounded-3" style="background-color: #fff; border-left: 5px solid #D81324;">
            <p class="mb-2"><strong>Customer:</strong> {{ $booking->name }}</p>
            <p class="mb-2"><strong>Service:</strong> {{ $booking->service }}</p>
            <p class="mb-2"><strong>Date:</strong> {{ $booking->service_date }}</p>
        </div>

        <!-- Amount Card -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, #FFE5E5, #FFD1D1); box-shadow: 0 4px 15px rgba(216,19,36,0.2);">
            <strong style="font-size:18px; color:#D81324;">Amount to Pay</strong>
            <span style="font-size:20px; font-weight:bold; color:#D81324;">₹{{ $paymentOrder['amount']/100 }}</span>
        </div>

        <!-- Razorpay Button -->
        <form action="{{ route('payment.verify') }}" method="POST" class="text-center">
            @csrf
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ env('RAZORPAY_KEY') }}"
                data-amount="{{ $paymentOrder['amount'] }}"
                data-currency="INR"
                data-order_id="{{ $paymentOrder['id'] }}"
                data-buttontext="Pay Securely"
                data-name="Indian Color Point & Autoglass"
                data-description="Booking Payment"
                data-prefill.name="{{ $booking->name }}"
                data-prefill.email="{{ $booking->email }}"
                data-theme.color="#D81324">
            </script>
        </form>

        <!-- Footer Note -->
        <div class="text-center mt-3">
            <small class="text-muted">🔒 100% Secure Payment powered by Razorpay</small>
        </div>

    </div>

</div>

@endsection
