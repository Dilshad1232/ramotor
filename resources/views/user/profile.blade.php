@extends('user.main')

@section('title', 'User Profile')

@section('content')

<h2 class="page-title">👤 User Profile</h2>

<div class="glass-card profile-card">

    {{-- Left: Profile Image --}}
    <div class="profile-left">
        @if($user->profile_image)
            <img src="{{ asset('uploads/profile/' . $user->profile_image) }}" class="profile-img">
        @else
            <div class="no-img">No Image</div>
        @endif
    </div>

    {{-- Right: Profile Details --}}
    <div class="profile-right">
        <div class="profile-info">

            <div class="info-row">
                <span class="info-label">Full Name:</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $user->phone }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Address:</span>
                <span class="info-value">{{ $user->address ?? '-' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">City:</span>
                <span class="info-value">{{ $user->city ?? '-' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Pincode:</span>
                <span class="info-value">{{ $user->pincode ?? '-' }}</span>
            </div>

        </div>

        {{-- Buttons --}}
        <div class="profile-buttons">
            <a href="{{ route('user.dashboard') }}" class="btn cancel-btn">Dashboard</a>
            <a href="{{ route('user.profile.edit') }}" class="btn update-btn">Update Profile</a>
        </div>
    </div>

</div>

<style>

.page-title {
    color:#ff4d4d;
    font-size:1.7rem;
    font-weight:700;
    margin-bottom:25px;
    text-align:center;
}

/* MAIN CARD */
.profile-card {
    width:90%;
    max-width:1100px;
    margin:auto;
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    background: rgba(255,255,255,0.06);
    border-radius:18px;
    padding:35px;
    border:1px solid rgba(255,255,255,0.15);
    box-shadow:0 15px 35px rgba(0,0,0,0.6);
    overflow:hidden;
}

/* LEFT IMAGE */
.profile-left {
    flex:0 0 200px;
    text-align:center;
}

.profile-img {
    width:150px;
    height:150px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #ff4d4d;
    margin-bottom:15px;
}

.no-img {
    width:150px;
    height:150px;
    border-radius:50%;
    background:#444;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-weight:600;
    margin-bottom:15px;
}

/* RIGHT DETAILS */
.profile-right {
    flex:1;
    min-width:250px;
}

.profile-info {
    display:flex;
    flex-direction:column;
    gap:12px;
}

.info-row {
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}

.info-label {
    width:120px;
    font-weight:600;
    color:#ff4d4d;
    flex-shrink:0;
}

.info-value {
    color:#fff;
    font-size:1rem;
    word-break:break-word;
}

/* BUTTONS */
.profile-buttons {
    margin-top:30px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    justify-content:flex-start;
}

.cancel-btn {
    background:#444;
    color:white;
    padding:10px 22px;
    border-radius:8px;
    text-decoration:none;
    text-align:center;
}

.update-btn {
    background:#D81324;
    color:white;
    padding:10px 22px;
    border-radius:8px;
    text-decoration:none;
    text-align:center;
}

/* MOBILE RESPONSIVE */
@media(max-width:767px){
    .profile-card {
        flex-direction:column;
        text-align:center;
        align-items:center;
        padding:25px;
    }
    .profile-left { margin-bottom:20px; }
    .info-row { flex-direction:column; align-items:center; }
    .info-label { width:100%; text-align:center; margin-bottom:3px; }
    .profile-buttons { flex-direction:column; align-items:center; width:100%; }
    .profile-buttons .btn { width:100%; max-width:250px; }
}
</style>

@endsection
