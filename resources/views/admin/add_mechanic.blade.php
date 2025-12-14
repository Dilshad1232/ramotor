@extends('admin.main')
@section('title', 'Add Mechanic')

@section('content')

<style>
body {
    background: #121212;
    font-family: 'Poppins', sans-serif;
}

.page-title {
    color: #ff4d4d;
    font-size: 1.7rem;
    font-weight: 700;
    margin-bottom: 25px;
    text-align: center;
}

/* Card */
.glass-card {
    background: #1a1a1a;
    border-radius: 22px;
    padding: 30px;
    border: 1px solid #222;
    box-shadow: 8px 8px 16px #0d0d0d,
                -8px -8px 16px #262626;
    margin: 20px auto;
    transition: 0.4s;
}
.glass-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 12px 12px 20px #0b0b0b,
                -12px -12px 20px #262626;
}

/* Form */
.mechanic-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.form-group label {
    font-weight: 600;
    color: #ff4d4d;
    margin-bottom: 5px;
}
.input-box {
    position: relative;
}
.input-box .icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #ff4d4d;
}
.input-box input {
    width: 100%;
    padding: 12px 12px 12px 40px;
    border-radius: 14px;
    border: none;
    background: #1b1b1b;
    color: #fff;
    box-shadow: inset 4px 4px 8px #0b0b0b,
                inset -4px -4px 8px #2a2a2a;
    transition: 0.3s;
}
.input-box input:focus {
    outline: none;
    box-shadow: inset 2px 2px 6px #0b0b0b,
                inset -2px -2px 6px #2a2a2a,
                0 0 8px #ff4d4d;
}
.file-upload input {
    padding: 12px;
    background: #1b1b1b;
    border-radius: 14px;
    border: none;
    color: #fff;
    box-shadow: inset 4px 4px 8px #0b0b0b,
                inset -4px -4px 8px #2a2a2a;
}
.btn-submit {
    padding: 13px;
    background: #ff4d4d;
    color: #fff;
    border: none;
    font-weight: 700;
    border-radius: 14px;
    cursor: pointer;
    box-shadow: 4px 4px 10px #0d0d0d,
                -4px -4px 10px #262626;
    transition: 0.3s;
}
.btn-submit:hover {
    background: #e63b3b;
    letter-spacing: 1px;
}

/* Table */
.table-responsive {
    width: 100%;
    overflow-x: auto; /* horizontal scroll for small screens */
}

.mechanics-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
    color: #fff;
}

.mechanics-table th, .mechanics-table td {
    padding: 14px 12px;
    text-align: center;
    vertical-align: middle;
}

.mechanics-table thead {
    background: #ff4d4d;
    color: #fff;
}

.mechanics-table tbody tr {
    border-bottom: 1px solid #222;
    transition: background 0.3s, box-shadow 0.3s;
    box-shadow: inset 4px 4px 8px #0b0b0b,
                inset -4px -4px 8px #2a2a2a;
    border-radius: 12px;
    margin-bottom: 6px;
}

.mechanics-table tbody tr:hover {
    background: rgba(255,77,77,0.1);
}

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

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 6px;
    align-items: center;
}

.btn-edit, .btn-delete {
    padding: 6px 12px;
    border-radius: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}

.btn-edit {
    background: #00ff66;
    color: #000;
    box-shadow: 4px 4px 8px #0d0d0d,
                -4px -4px 8px #262626;
}
.btn-edit:hover { background: #00cc52; }

.btn-delete {
    background: #ff4d4d;
    color: #fff;
    border: none;
    cursor: pointer;
    box-shadow: 4px 4px 8px #0d0d0d,
                -4px -4px 8px #262626;
}
.btn-delete:hover { background: #e60000; }

.no-data {
    text-align: center;
    padding: 20px 0;
    color: #aaa;
}

/* Pagination + Search */
.table-top {
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
    flex-wrap:wrap;
}

.input-box.small {
    width:150px;
}

.pagination-box button {
    border:1px solid #ff4d4d;
    background:none;
    color:#ff4d4d;
    padding:5px 12px;
    border-radius:6px;
    margin:2px;
    transition:0.3s;
}

.pagination-box button.active,
.pagination-box button:hover {
    background:#ff4d4d;
    color:#fff;
}

/* Responsive: keep table structure, scroll horizontally */
@media(max-width:768px){
    .table-responsive { overflow-x:auto; }
    .mechanics-table { min-width:600px; }
}
</style>

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
        </div>
        <div class="form-group">
            <label>Email</label>
            <div class="input-box">
                <i class="fa fa-envelope icon"></i>
                <input type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <div class="input-box">
                <i class="fa fa-phone icon"></i>
                <input type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Specialization</label>
            <div class="input-box">
                <i class="fa fa-gear icon"></i>
                <input type="text" name="specialization" placeholder="Engine Repair, Electrical…" value="{{ old('specialization') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Profile Image</label>
            <div class="file-upload">
                <input type="file" name="profile_image" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn-submit"><i class="fa fa-plus-circle"></i> Add Mechanic</button>
    </form>
</div>

<h2 class="page-title">🛠️ Mechanics List</h2>
<div class="glass-card wide-card">
    <div class="table-top">
        <input type="text" id="searchBox" class="input-box small" placeholder="Search mechanics...">
        <select id="entries" class="input-box small">
            <option>5</option>
            <option selected>10</option>
            <option>25</option>
            <option>50</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="mechanics-table" id="mechanicTable">
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
                    <td> {{ $i + 1 }} </td>
                    <td> {{ $mechanic->name }} </td>
                    <td> {{ $mechanic->email }} </td>
                    <td> {{ $mechanic->phone }} </td>
                    <td> {{ $mechanic->specialization }} </td>
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

        <div class="table-bottom">
            <div id="recordInfo"></div>
            <div id="paginationBtns" class="pagination-box"></div>
        </div>
    </div>
</div>

<script>
let table = document.querySelector("#mechanicTable tbody");
let rows = table.querySelectorAll("tr");
let paginationBtns = document.getElementById("paginationBtns");
let recordInfo = document.getElementById("recordInfo");
let entriesSelect = document.getElementById("entries");
let searchBox = document.getElementById("searchBox");
let currentPage = 1;

function displayTable() {
    let max = parseInt(entriesSelect.value);
    let search = searchBox.value.toLowerCase();
    let filtered = [];

    rows.forEach(r => {
        r.style.display = r.innerText.toLowerCase().includes(search) ? "" : "none";
        if (r.style.display !== "none") filtered.push(r);
    });

    let total = filtered.length;
    let pages = Math.ceil(total / max);
    if (currentPage > pages) currentPage = pages || 1;

    let start = (currentPage - 1) * max;
    let end = start + max;

    filtered.forEach((r, i) => r.style.display = i >= start && i < end ? "" : "none");

    recordInfo.innerHTML = `Showing <b>${start+1}</b> – <b>${Math.min(end,total)}</b> of <b>${total}</b>`;

    paginationBtns.innerHTML = "";
    for (let i = 1; i <= pages; i++) {
        let btn = document.createElement("button");
        btn.innerText = i;
        btn.classList.toggle("active", i === currentPage);
        btn.onclick = () => { currentPage = i; displayTable(); };
        paginationBtns.appendChild(btn);
    }
}

entriesSelect.addEventListener("change", () => (currentPage = 1, displayTable()));
searchBox.addEventListener("keyup", () => (currentPage = 1, displayTable()));
document.addEventListener("DOMContentLoaded", displayTable);
</script>

@endsection
