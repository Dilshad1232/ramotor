@extends('user.main')

@section('title','Contact Us')

@section('content')

<style>

    body {
        background: #121212;
    }

    .contact-wrapper {
        max-width: 850px;
        margin: auto;
        padding: 20px;
        margin-top: 30px;
    }

    .contact-card {
        background: #1a1a1a;
        padding: 35px;
        border-radius: 22px;
        box-shadow:
            8px 8px 16px #0d0d0d,
            -8px -8px 16px #262626;
        border: 1px solid #222;
    }

    .contact-title {
        text-align: center;
        font-size: 34px;
        font-weight: 800;
        color: #ff4d4d;
        margin-bottom: 12px;
    }

    .contact-desc {
        text-align: center;
        color: #bbb;
        margin-bottom: 30px;
        font-size: 15px;
    }

    /* Input Box */
    .input-field {
        background: #1b1b1b;
        border-radius: 14px;
        border: none;
        width: 100%;
        padding: 14px;
        color: #fff;
        font-size: 15px;
        margin-bottom: 5px;
        box-shadow: inset 4px 4px 8px #0b0b0b,
                    inset -4px -4px 8px #2a2a2a;
        transition: 0.3s ease;
    }

    /* Focus Glow */
    .input-field:focus {
        outline: none;
        box-shadow: inset 2px 2px 6px #0b0b0b,
                    inset -2px -2px 6px #2a2a2a,
                    0 0 8px #ff4d4d;
        border: 1px solid #ff4d4d;
    }

    /* Error Red Highlight */
    .input-error {
        border: 1px solid #ff3333 !important;
        box-shadow: inset 2px 2px 6px #0b0b0b,
                    inset -2px -2px 6px #2a2a2a,
                    0 0 8px rgba(255, 0, 0, 0.8) !important;
    }

    /* Error Text */
    .error-text {
        color: #ff4d4d;
        font-size: 13px;
        margin-bottom: 12px;
        padding-left: 5px;
    }

    /* Submit Button */
    .btn-send {
        width: 100%;
        padding: 13px;
        background: #ff4d4d;
        border: none;
        border-radius: 14px;
        color: #fff;
        font-weight: 700;
        font-size: 18px;
        margin-top: 20px;
        transition: 0.3s;
        box-shadow:
            4px 4px 10px #0d0d0d,
            -4px -4px 10px #262626;
    }

    .btn-send:hover {
        background: #e63b3b;
        letter-spacing: 1px;
    }

    /* Success Alert */
    .success-alert {
        background: rgba(0, 255, 0, 0.08);
        border-left: 5px solid #00ff55;
        padding: 12px 15px;
        border-radius: 10px;
        color: #00ff88;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Error Alert Box */
    .error-alert {
        background: rgba(255, 0, 0, 0.08);
        border-left: 5px solid #ff3333;
        padding: 12px 15px;
        border-radius: 10px;
        color: #ff7777;
        font-size: 14px;
        margin-bottom: 20px;
    }

</style>


<div class="contact-wrapper">
    <div class="contact-card">

        <h2 class="contact-title">📞 Contact Us</h2>
        <p class="contact-desc">Feel free to contact us for any help, support, or questions!</p>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- GLOBAL VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="error-alert">
                Please fix the errors below and try again.
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="form-box">

                <label>Your Name</label>
                <input type="text"
                       class="input-field @error('name') input-error @enderror"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter your name" >
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <label>Your Email</label>
                <input type="email"
                       class="input-field @error('email') input-error @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter your email" >
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <label>Subject</label>
                <input type="text"
                       class="input-field @error('subject') input-error @enderror"
                       name="subject"
                       value="{{ old('subject') }}"
                       placeholder="Enter subject" >
                @error('subject')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <label>Phone</label>
                <input type="text"
                       class="input-field @error('phone') input-error @enderror"
                       name="phone"
                       value="{{ old('phone') }}"
                       placeholder="Enter phone number">
                @error('phone')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <label>Your Message</label>
                <textarea
                    class="input-field @error('message') input-error @enderror"
                    name="message"
                    rows="4"
                    placeholder="Type your message..."
                    >{{ old('message') }}</textarea>
                @error('message')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-send">Send Message</button>

            </div>

        </form>

    </div>
</div>

@endsection
