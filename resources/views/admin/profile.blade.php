@extends('admin.main')

@section('title', 'Admin Profile')

@section('content')

<div class="profile-wrapper">

    <h2 class="profile-title">👤 Admin Profile</h2>

    <div class="profile-card profile-view">

        <div class="profile-flex">
            {{-- LEFT: Profile Image --}}
            <div class="profile-image-section">
                @if($admin->profile_image)
                    <img src="{{ asset('uploads/admin/' . $admin->profile_image) }}" alt="Profile Image">
                @else
                    <div class="no-image">No Image</div>
                @endif
            </div>

            {{-- RIGHT: Profile Details --}}
            <div class="profile-inputs">
                <div class="view-row">
                    <div class="view-col">
                        <span class="profile-label">Full Name:</span>
                        <span class="profile-value">{{ $admin->name }}</span>
                    </div>
                    <div class="view-col">
                        <span class="profile-label">Email:</span>
                        <span class="profile-value">{{ $admin->email }}</span>
                    </div>
                </div>

                <div class="view-row">
                    <div class="view-col">
                        <span class="profile-label">Phone:</span>
                        <span class="profile-value">{{ $admin->phone }}</span>
                    </div>
                    <div class="view-col">
                        <span class="profile-label">Address:</span>
                        <span class="profile-value">{{ $admin->address ?? '-' }}</span>
                    </div>
                </div>

                <div class="view-row">
                    <div class="view-col">
                        <span class="profile-label">City:</span>
                        <span class="profile-value">{{ $admin->city ?? '-' }}</span>
                    </div>
                    <div class="view-col">
                        <span class="profile-label">Pincode:</span>
                        <span class="profile-value">{{ $admin->pincode ?? '-' }}</span>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="button-row">
                    <a href="{{ route('admin.dashboard') }}" class="btn cancel-btn">Dashboard</a>
                    <a href="{{ route('admin.profile.edit') }}" class="btn update-btn">Update Profile</a>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
body { background:#121212; margin:0; padding:0; }

.profile-wrapper { max-width:900px; margin:auto; margin-top:30px; padding:10px; }

.profile-title { text-align:center; font-size:34px; font-weight:800; color:#ff4d4d; margin-bottom:25px; }

.profile-card {
    background:#1a1a1a;
    padding:25px;
    border-radius:22px;
    box-shadow:8px 8px 16px #0d0d0d, -8px -8px 16px #262626;
    border:1px solid #222;
    color:#fff;
    overflow:hidden;
}

.profile-flex { display:flex; gap:30px; flex-wrap:wrap; align-items:flex-start; }

.profile-image-section { flex:0 0 200px; text-align:center; }
.profile-image-section img {
    width:160px; height:160px; border-radius:50%; object-fit:cover;
    border:4px solid #ff4d4d; margin-bottom:15px;
    box-shadow:4px 4px 10px #0d0d0d, -4px -4px 10px #262626;
    transition: transform 0.3s;
}
.profile-image-section img:hover { transform: scale(1.05); }

.no-image {
    width:160px; height:160px; border-radius:50%; background:#444;
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-weight:600; margin-bottom:15px;
    box-shadow:4px 4px 10px #0d0d0d, -4px -4px 10px #262626;
}

.profile-inputs { flex:1; min-width:200px; }

.view-row { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:15px; width:100%; }
.view-col { display:flex; flex:1 1 100%; align-items:center; min-width:120px; }

.profile-label { width:120px; font-weight:600; color:#ff4d4d; }
.profile-value { color:#fff; flex:1; word-break:break-word; }

.button-row {
    margin-top:20px; display:flex; gap:15px; flex-wrap:wrap;
}
.cancel-btn, .update-btn {
    padding:10px 22px; border-radius:8px; text-decoration:none; text-align:center;
    box-shadow: 2px 2px 6px #0d0d0d, -2px -2px 6px #262626;
    transition:0.3s;
}
.cancel-btn { background:#444; color:white; }
.update-btn { background:#D81324; color:white; }
.cancel-btn:hover, .update-btn:hover { opacity:0.9; }

/* Mobile Fix */
@media(max-width:767px){
    .profile-flex { flex-direction:column; align-items:center; }
    .profile-image-section { flex:0 0 auto; margin-bottom:15px; }
    .view-row { flex-direction:column; gap:10px; }
    .view-col { flex-direction:row; justify-content:flex-start; width:100%; }
    .profile-label { width:120px; text-align:left; }
    .profile-value { flex:1; word-break:break-word; }
    .button-row { justify-content:center; width:100%; }
}
</style>

@endsection
