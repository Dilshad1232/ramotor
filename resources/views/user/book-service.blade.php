@extends('user.main')

@section('title','Book a Service')

@section('content')

<style>

    body {
        background: #121212;
    }

    .booking-wrapper {
        max-width: 850px;
        margin: auto;
        padding: 20px;
        margin-top: 30px;
    }

    .booking-card {
        background: #1a1a1a;
        padding: 35px;
        border-radius: 22px;
        box-shadow:
            8px 8px 16px #0d0d0d,
            -8px -8px 16px #262626;
        border: 1px solid #222;
        color: #fff;
    }

    .booking-title {
        text-align: center;
        font-size: 34px;
        font-weight: 800;
        color: #ff4d4d;
        margin-bottom: 12px;
    }

    .booking-desc {
        text-align: center;
        color: #bbb;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .form-box label {
        font-weight: 600;
        color: #ccc;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .input-field {
        background: #1b1b1b;
        border-radius: 14px;
        border: none;
        width: 100%;
        padding: 14px;
        color: #fff;
        font-size: 15px;
        margin-bottom: 20px;
        box-shadow: inset 4px 4px 8px #0b0b0b,
                    inset -4px -4px 8px #2a2a2a;
        transition: 0.3s ease;
    }

    .input-field:focus {
        outline: none;
        box-shadow: inset 2px 2px 6px #0b0b0b,
                    inset -2px -2px 6px #2a2a2a,
                    0 0 8px #ff4d4d;
        border: 1px solid #ff4d4d;
    }

    .btn-send {
        width: 100%;
        padding: 13px;
        background: #ff4d4d;
        border: none;
        border-radius: 14px;
        color: #fff;
        font-weight: 700;
        font-size: 18px;
        margin-top: 10px;
        transition: 0.3s;
        box-shadow:
            4px 4px 10px #0d0d0d,
            -4px -4px 10px #262626;
    }

    .btn-send:hover {
        background: #e63b3b;
        letter-spacing: 1px;
    }

    .error {
        color:#ff4d4d;
        font-size:13px;
        margin-top:-10px;
        margin-bottom:10px;
        font-weight:600;
    }

</style>


<div class="booking-wrapper">

    <div class="booking-card">

        <h2 class="booking-title">🛠 Book a Service</h2>
        <p class="booking-desc">Fill in your details to schedule your car service.</p>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div style="
                background:#d4edda;
                color:#155724;
                padding:12px 20px;
                margin-bottom:20px;
                border-radius:12px;
                text-align:center;
                border-left:6px solid #28a745;
            ">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="form-box">

                <label>Full Name *</label>
                <input type="text" name="name" class="input-field"
                       value="{{ old('name') }}" placeholder="Your full name">
                @error('name') <div class="error">{{ $message }}</div> @enderror

                <label>Email *</label>
                <input type="email" name="email" class="input-field"
                       value="{{ old('email', auth()->user()->email) }}" placeholder="Your email">
                @error('email') <div class="error">{{ $message }}</div> @enderror

                <label>Phone *</label>
                <input type="text" name="phone" class="input-field"
                       value="{{ old('phone', auth()->user()->phone) }}" placeholder="Phone number">
                @error('phone') <div class="error">{{ $message }}</div> @enderror

                <label>Address</label>
                <input type="text" name="address" class="input-field"
                       value="{{ old('address', auth()->user()->address) }}" placeholder="Your address">
                @error('address') <div class="error">{{ $message }}</div> @enderror

                <label>Service *</label>
                <select name="service" class="input-field">
                    <option value="">-- Select Service --</option>
                    <option value="Car Wash" {{ old('service')=='Car Wash'?'selected':'' }}>Car Wash</option>
                    <option value="Engine Check" {{ old('service')=='Engine Check'?'selected':'' }}>Engine Check</option>
                    <option value="Oil Change" {{ old('service')=='Oil Change'?'selected':'' }}>Oil Change</option>
                    <option value="Tyre Replacement" {{ old('service')=='Tyre Replacement'?'selected':'' }}>Tyre Replacement</option>
                </select>
                @error('service') <div class="error">{{ $message }}</div> @enderror

                <label>Service Date *</label>
                <input type="date" name="service_date" class="input-field"
                       value="{{ old('service_date') }}">
                @error('service_date') <div class="error">{{ $message }}</div> @enderror

                <label>Special Request</label>
                <textarea name="special_request" rows="4" class="input-field"
                          placeholder="Any special instructions?">{{ old('special_request') }}</textarea>

                <button type="submit" class="btn-send">Book Now</button>

            </div>

        </form>

    </div>

</div>

@endsection
{{-- END OF CONTENT --}}
