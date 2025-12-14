@extends('user.main')

@section('title','Edit User Profile')

@section('content')

<style>

    body {
        background: #121212;
    }

    .profile-wrapper {
        max-width: 900px;
        margin: auto;
        margin-top: 30px;
        padding: 20px;
    }

    .profile-card {
        background: #1a1a1a;
        padding: 35px;
        border-radius: 22px;
        box-shadow:
            8px 8px 16px #0d0d0d,
            -8px -8px 16px #262626;
        border: 1px solid #222;
        color: #fff;
    }

    .profile-title {
        text-align: center;
        font-size: 34px;
        font-weight: 800;
        color: #ff4d4d;
        margin-bottom: 12px;
    }

    .profile-desc {
        text-align: center;
        color: #bbb;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .input-label {
        color: #ccc;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
        font-weight: 600;
    }

    .input-field {
        background: #1b1b1b;
        border-radius: 14px;
        border: none;
        width: 100%;
        padding: 14px;
        color: #fff;
        font-size: 15px;
        margin-bottom: 18px;
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

    .profile-flex {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .profile-image-section {
        flex: 0 0 220px;
        text-align: center;
    }

    .profile-image-section img {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ff4d4d;
        margin-bottom: 15px;
        box-shadow:
            4px 4px 10px #0d0d0d,
            -4px -4px 10px #262626;
    }

    .profile-inputs {
        flex: 1;
    }

    .input-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .input-col {
        flex: 1;
    }

    .btn-update {
        width: 100%;
        background: #ff4d4d;
        padding: 13px;
        border-radius: 14px;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 700;
        margin-top: 20px;
        transition: 0.3s;
        box-shadow:
            4px 4px 10px #0d0d0d,
            -4px -4px 10px #262626;
    }

    .btn-update:hover {
        background: #e63b3b;
        letter-spacing: 1px;
    }

    .success-box {
        background:#d4edda;
        color:#155724;
        padding:12px 18px;
        margin-bottom:20px;
        border-left:5px solid #28a745;
        border-radius:10px;
        text-align:center;
        font-weight:600;
    }

    @media(max-width: 768px){
        .profile-flex { flex-direction:column; text-align:center; }
        .input-row { flex-direction:column; }
    }

</style>

<div class="profile-wrapper">

    @if(session('success'))
        <div class="success-box">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-card">

        <h2 class="profile-title">✏️ Edit Profile</h2>
        <p class="profile-desc">Update your profile details anytime.</p>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-flex">

                {{-- LEFT IMAGE --}}
                <div class="profile-image-section">
                    <img src="{{ $user->profile_image ? asset('uploads/profile/' . $user->profile_image) : asset('default-avatar.png') }}" alt="Profile Image">

                    <label class="input-label">Change Image</label>
                    <input type="file" name="profile_image" class="input-field" style="padding:10px;">
                </div>

                {{-- RIGHT INPUTS --}}
                <div class="profile-inputs">

                    <div class="input-row">
                        <div class="input-col">
                            <label class="input-label">Full Name</label>
                            <input type="text" class="input-field" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="input-col">
                            <label class="input-label">Email</label>
                            <input type="email" class="input-field" value="{{ $user->email }}" disabled>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-col">
                            <label class="input-label">Phone</label>
                            <input type="text" class="input-field" name="phone" value="{{ $user->phone }}" required>
                        </div>

                        <div class="input-col">
                            <label class="input-label">Address</label>
                            <input type="text" class="input-field" name="address" value="{{ $user->address }}">
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-col">
                            <label class="input-label">City</label>
                            <input type="text" class="input-field" name="city" value="{{ $user->city }}">
                        </div>

                        <div class="input-col">
                            <label class="input-label">Pincode</label>
                            <input type="text" class="input-field" name="pincode" value="{{ $user->pincode }}">
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn-update">Update Profile</button>

        </form>

    </div>

</div>

@endsection
