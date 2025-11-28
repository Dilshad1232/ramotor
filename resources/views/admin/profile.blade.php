@extends('admin.main')

@section('title', 'Admin Profile')

@section('content')

<h2 class="page-title">👤 Admin Profile</h2>

<div class="glass-card" style="width:90%; max-width:1100px; margin:auto; display:flex; flex-wrap:wrap; gap:30px; align-items:flex-start;">

    {{-- Left: Profile Image --}}
    <div style="flex:0 0 200px; text-align:center;">
        @if($admin->profile_image)
            <img src="{{ asset('uploads/admin/' . $admin->profile_image) }}"
                 style="width:150px;height:150px;border-radius:50%;object-fit:cover; border:3px solid #ff4d4d; margin-bottom:15px;">
        @else
            <div style="width:150px;height:150px;border-radius:50%;background:#444;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600; margin-bottom:15px;">
                No Image
            </div>
        @endif
    </div>

    {{-- Right: Profile Details --}}
    <div style="flex:1; min-width:300px;">
        <div style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <span class="profile-label">Full Name:</span>
                <span class="profile-value">{{ $admin->name }}</span>
            </div>
            <div>
                <span class="profile-label">Email:</span>
                <span class="profile-value">{{ $admin->email }}</span>
            </div>
            <div>
                <span class="profile-label">Phone:</span>
                <span class="profile-value">{{ $admin->phone }}</span>
            </div>
            <div>
                <span class="profile-label">Address:</span>
                <span class="profile-value">{{ $admin->address ?? '-' }}</span>
            </div>
            <div>
                <span class="profile-label">City:</span>
                <span class="profile-value">{{ $admin->city ?? '-' }}</span>
            </div>
            <div>
                <span class="profile-label">Pincode:</span>
                <span class="profile-value">{{ $admin->pincode ?? '-' }}</span>
            </div>
        </div>

        {{-- Buttons --}}
        <div style="margin-top:30px; display:flex; gap:15px; flex-wrap:wrap;">
            <a href="{{ route('admin.dashboard') }}" class="btn cancel-btn">Dashboard</a>
            <a href="{{ route('admin.profile.edit') }}" class="btn update-btn">Update Profile</a>
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

.glass-card {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 35px;
    border:1px solid rgba(255,255,255,0.15);
    box-shadow:0 15px 35px rgba(0,0,0,0.6);
}

.profile-label {
    display:inline-block;
    width:120px;
    font-weight:600;
    color:#ff4d4d;
}

.profile-value {
    color:#fff;
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
    text-align:center;
}

.btn:hover { opacity:0.9; }
@media(max-width:767px) {
    .glass-card { flex-direction:column; align-items:center; }
    .profile-label { width:100px; display:inline-block; }
}
</style>

@endsection
