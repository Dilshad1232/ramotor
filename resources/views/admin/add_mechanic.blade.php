@extends('admin.main')

@section('title', 'Add Mechanic')

@section('content')

<h2 class="page-title">🚗 Add New Mechanic</h2>

<div class="glass-card">
    @if(session('success'))
    <div style="background:#00ff66;color:black;padding:10px;border-radius:8px;margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.mechanic.store') }}" method="POST" enctype="multipart/form-data" class="mechanic-form">
    @csrf

    <div class="form-group">
        <label>Full Name</label>
        <div class="input-box">
            <i class="fa fa-user icon"></i>
            <input type="text" name="name" placeholder="Enter full name" value="{{ old('name') }}" required>
        </div>
        @error('name')
            <span style="color:#ff4d4d;font-size:0.9rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Email</label>
        <div class="input-box">
            <i class="fa fa-envelope icon"></i>
            <input type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>
        </div>
        @error('email')
            <span style="color:#ff4d4d;font-size:0.9rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Phone</label>
        <div class="input-box">
            <i class="fa fa-phone icon"></i>
            <input type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}" required>
        </div>
        @error('phone')
            <span style="color:#ff4d4d;font-size:0.9rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Specialization</label>
        <div class="input-box">
            <i class="fa fa-gear icon"></i>
            <input type="text" name="specialization" placeholder="Engine Repair, Electrical…" value="{{ old('specialization') }}" required>
        </div>
        @error('specialization')
            <span style="color:#ff4d4d;font-size:0.9rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Profile Image</label>
        <div class="file-upload">
            <input type="file" name="profile_image" accept="image/*">
        </div>
        @error('profile_image')
            <span style="color:#ff4d4d;font-size:0.9rem;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn-submit">
        <i class="fa fa-plus-circle"></i> Add Mechanic
    </button>
</form>

</div>


<style>

.page-title {
    color: #ff4d4d;
    font-size: 1.7rem;
    font-weight: 700;
    margin-bottom: 25px;
}

/* Glass 3D Card */
.glass-card {
    width: 55%;
    margin: auto;
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 30px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 15px 35px rgba(0,0,0,0.6);
    transition: 0.4s;
}



.glass-card:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 25px 45px rgba(0,0,0,0.8);
}

.mechanic-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.form-group label {
    font-weight: 600;
    color: #ff4d4d;
    margin-bottom: 5px;
}

/* Input Box */
.input-box {
    position: relative;
}
.input-box .icon {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #ff4d4d;
    font-size: 1rem;
}
.input-box input {
    width: 100%;
    padding: 12px 12px 12px 40px;
    border: 1px solid #444;
    border-radius: 10px;
    background: #111;
    color: white;
    transition: 0.3s;
}
.input-box input:focus {
    border-color: #ff4d4d;
    box-shadow: 0 0 10px #ff4d4d80;
    outline: none;
}

/* File Upload */
.file-upload input {
    padding: 12px;
    background: #111;
    border-radius: 10px;
    border: 1px solid #444;
    color: white;
}

/* Submit Button */
.btn-submit {
    margin-top: 10px;
    padding: 12px;
    border: none;
    font-size: 1rem;
    font-weight: bold;
    background: linear-gradient(135deg, #ff4d4d, #ff1a1a);
    color: white;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(255, 50, 50, 0.4);
}
.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255, 50, 50, 0.6);
}

/* Mobile Responsive */
@media(max-width: 768px) {
    .glass-card {
        width: 100%;
        padding: 20px;
    }
    .btn-submit {
        font-size: 0.9rem;
    }
}
/* @media(max-width: 768px) {
    .glass-card {
        width: 100%;
        padding: 20px;
    }
} */
</style>


<!-- Mechanics Table -->
<h2 class="page-title" style="margin-top:40px;">🛠️ Mechanics List</h2>

<div class="glass-card wide-card">
    <div class="table-responsive">
        <table class="mechanics-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Profile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mechanics as $i => $mechanic)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $mechanic->name }}</td>
                    <td>{{ $mechanic->email }}</td>
                    <td>{{ $mechanic->phone }}</td>
                    <td>{{ $mechanic->specialization }}</td>
                    <td>
                        @if($mechanic->profile_image)
                            <img src="{{ asset($mechanic->profile_image) }}" alt="Profile" class="profile-img">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                        <td class="action-buttons">
                            <a href="#" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.mechanic.destroy', $mechanic->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-data">No mechanics found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* Glass-card width update */
.wide-card {
    width: 100%; /* bada width */
    margin: auto;
    padding: 30px;
}

/* Table Styling */
.table-responsive {
    overflow-x:auto;
}

.mechanics-table {
    width: 100%;
    border-collapse: collapse;
    color: white;
    min-width: 800px; /* table ko thoda wide */
}

.mechanics-table th, .mechanics-table td {
    padding: 14px 12px;
    text-align: left;
    font-size: 0.95rem;
}

.mechanics-table thead {
    background: #ff4d4d;
    color: white;
}

.mechanics-table tbody tr {
    border-bottom: 1px solid #444;
    transition: background 0.3s;
}

.mechanics-table tbody tr:hover {
    background: rgba(255,77,77,0.1);
}

/* Profile Image */
.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s;
}

.profile-img:hover {
    transform: scale(1.1);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 5px;
    align-items: center;
}

.btn-edit, .btn-delete {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-edit {
    background: #00ff66;
    color: black;
}

.btn-edit:hover {
    background: #00cc52;
}

.btn-delete {
    background: #ff4d4d;
    color: white;
    border: none;
    cursor: pointer;
}

.btn-delete:hover {
    background: #e60000;
}

/* No data row */
.no-data {
    text-align: center;
    padding: 20px 0;
    color: #aaa;
}

/* Mobile Responsive */
@media(max-width:768px){
    .wide-card {
        width: 95%;
        padding: 20px;
    }
    .mechanics-table, .mechanics-table thead, .mechanics-table tbody, .mechanics-table th, .mechanics-table td, .mechanics-table tr { display:block; }
    .mechanics-table thead { display:none; }
    .mechanics-table tbody tr { margin-bottom:15px; background:#111; border-radius:10px; padding:10px; }
    .mechanics-table td {
        padding:8px;
        text-align:right;
        position: relative;
    }
    .mechanics-table td::before {
        content: attr(data-label);
        position: absolute;
        left:10px;
        width:50%;
        font-weight:600;
        text-align:left;
        color:#ff4d4d;
    }
    .action-buttons { justify-content:flex-end; }
}
</style>

@endsection
