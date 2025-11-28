@extends('admin.main')

@section('title', 'Edit Admin Profile')

@section('content')

<h2 class="page-title">✏️ Edit Profile</h2>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success" style="
        width:90%; max-width:1100px; margin:auto; margin-bottom:20px;
        background:#d4edda; color:#155724; padding:12px 18px;
        border-left:5px solid #28a745; border-radius:8px;">
        {{ session('success') }}
    </div>
@endif

<div class="glass-card" style="width:90%; max-width:1100px; margin:auto;">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:flex; gap:30px; flex-wrap:wrap;">
            {{-- Left: Image --}}
            <div style="flex:0 0 200px; text-align:center;">
                <img src="{{ $admin->profile_image ? asset('uploads/admin/' . $admin->profile_image) : asset('default-avatar.png') }}"
                     style="width:150px;height:150px;border-radius:50%;object-fit:cover; border:3px solid #ff4d4d; margin-bottom:15px;">
                <label class="form-label input-label">Change Profile Image</label>
                <input type="file" name="profile_image" class="form-control input-box">
            </div>

            {{-- Right: Inputs --}}
            <div style="flex:1; min-width:300px;">
                <div style="display:flex; gap:20px; flex-wrap:wrap;">
                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">Full Name</label>
                        <input type="text" name="name" class="form-control input-box" value="{{ $admin->name }}" required>
                    </div>

                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">Email</label>
                        <input type="email" name="email" class="form-control input-box" value="{{ $admin->email }}" required>
                    </div>
                </div>

                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:15px;">
                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">Phone</label>
                        <input type="text" name="phone" class="form-control input-box" value="{{ $admin->phone }}" required>
                    </div>

                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">Address</label>
                        <input type="text" name="address" class="form-control input-box" value="{{ $admin->address }}">
                    </div>
                </div>

                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:15px;">
                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">City</label>
                        <input type="text" name="city" class="form-control input-box" value="{{ $admin->city }}">
                    </div>

                    <div style="flex:1; min-width:200px;">
                        <label class="form-label input-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control input-box" value="{{ $admin->pincode }}">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top:30px; display:flex; justify-content:space-between; flex-wrap:wrap; gap:10px;">
            <a href="{{ route('admin.profile') }}" class="btn cancel-btn">Cancel</a>
            <button type="submit" class="btn update-btn">Update</button>
        </div>

    </form>
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

.input-label {
    color:#ff4d4d;
    font-weight:600;
    display:block;
    margin-bottom:5px;
}

.input-box {
    background:rgba(255,255,255,0.85);
    border-radius:8px;
    padding:10px 14px;
    width:100%;
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
}

.btn:hover { opacity:0.9; }
</style>

@endsection
