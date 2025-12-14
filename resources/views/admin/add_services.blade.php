@extends('admin.main')
@section('title','Services')

@section('content')

<style>
body {
    background: #121212;
    font-family: 'Poppins', sans-serif;
}

.page-title {
    color:#ff4d4d;
    font-size:1.8rem;
    font-weight:700;
    margin-bottom:20px;
    text-align:center;
}

.glass-alert {
    width:90%;
    max-width:1100px;
    margin:auto;
    background:rgba(212,255,212,0.12);
    border:1px solid #28a745;
    color:#28e77a;
    padding:12px 16px;
    border-radius:12px;
    text-align:center;
    margin-bottom:20px;
}

.card-wrapper {
    max-width:1100px;
    margin:auto;
    margin-top:25px;
    padding:20px;
}

.card {
    background:#1a1a1a;
    padding:30px;
    border-radius:22px;
    box-shadow: 8px 8px 16px #0d0d0d,
                -8px -8px 16px #262626;
    border:1px solid #222;
    color:#fff;
}

.card-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.card-header h3 {
    color:#ff4d4d;
    font-weight:700;
    font-size:1.4rem;
}

.btn {
    border:none;
    padding:10px 20px;
    border-radius:14px;
    font-weight:700;
    cursor:pointer;
    text-decoration:none;
    box-shadow: 4px 4px 10px #0d0d0d,
                -4px -4px 10px #262626;
    transition:0.3s;
}

.add-btn {
    background:#ff4d4d;
    color:#fff;
}

.add-btn:hover {
    background:#e63b3b;
    letter-spacing:1px;
}

/* Inputs */
.input-box {
    width:100%;
    padding:14px;
    border-radius:14px;
    border:none;
    background:#1b1b1b;
    color:#fff;
    font-size:15px;
    box-shadow: inset 4px 4px 8px #0b0b0b,
                inset -4px -4px 8px #2a2a2a;
    transition:0.3s;
    margin-bottom:18px;
}

.input-box:focus {
    outline:none;
    box-shadow: inset 2px 2px 6px #0b0b0b,
                inset -2px -2px 6px #2a2a2a,
                0 0 8px #ff4d4d;
    border:1px solid #ff4d4d;
}

/* Table Design */
.table-wrapper {
    margin-top:25px;
    overflow-x:auto; /* Mobile fix */
}

.services-table {
    width:100%;
    border-collapse: collapse;
    color: #fff;
    min-width: 600px; /* ensures scroll on mobile */
}

.services-table th, .services-table td {
    padding: 14px 12px;
    text-align: center;
    vertical-align: middle;
}

.services-table thead {
    background: #ff4d4d;
    color: #fff;
}

.services-table tbody tr {
    border-bottom: 1px solid #222;
    transition: background 0.3s, box-shadow 0.3s;
    box-shadow: inset 4px 4px 8px #0b0b0b,
                inset -4px -4px 8px #2a2a2a;
    border-radius: 12px;
    margin-bottom: 6px;
}

.services-table tbody tr:hover {
    background: rgba(255,77,77,0.1);
}

.tbl-img {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 2px 2px 6px #0d0d0d,
                -2px -2px 6px #262626;
}

.tbl-icon {
    font-size:22px;
    color:#ff4d4d;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 6px;
    align-items: center;
}

.tbl-edit, .tbl-delete {
    padding:6px 12px;
    border-radius:14px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}

.tbl-edit {
    background: #00ff66;
    color: #000;
    box-shadow: 4px 4px 8px #0d0d0d,
                -4px -4px 8px #262626;
}
.tbl-edit:hover { background:#00cc52; }

.tbl-delete {
    background:#ff4d4d;
    color:#fff;
    border:none;
    cursor:pointer;
    box-shadow: 4px 4px 8px #0d0d0d,
                -4px -4px 8px #262626;
}
.tbl-delete:hover { background:#e60000; }

.no-data {
    text-align:center;
    padding:20px 0;
    color:#aaa;
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

/* Mobile Horizontal Scroll Fix */
@media(max-width:768px){
    .table-wrapper {
        overflow-x:auto; /* keep table scrollable */
    }
    .services-table {
        min-width: 600px; /* ensures horizontal scroll */
    }
}
</style>

<h2 class="page-title">🛠️ Manage Services</h2>

@if(session('success'))
<div class="glass-alert">
    {{ session('success') }}
</div>
@endif

<div class="card-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><i class="fa fa-gears"></i> Add New Service</h3>
            <a href="#" class="btn add-btn"><i class="fa fa-plus"></i> Add Service</a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div>
                    <label>Title *</label>
                    <input type="text" name="title" class="input-box" placeholder="Service Title*" required>
                </div>

                <div>
                    <label>Icon Class *</label>
                    <div class="input-with-icon">
                        <input type="text" name="icon" id="iconInput" class="input-box"
                               placeholder="fa-car-side, fa-tools"
                               onkeyup="previewIcon.className='fa '+this.value" required>
                        <i id="previewIcon" class="fa fa-car-side icon-preview"></i>
                    </div>
                </div>

                <div>
                    <label>Image *</label>
                    <input type="file" name="image" class="input-box" required>
                </div>

                <div class="full-row">
                    <label>Description *</label>
                    <textarea name="description" class="input-box" rows="2" placeholder="Short Description..." required></textarea>
                </div>
            </div>

            <button class="btn submit-btn"><i class="fa fa-check-circle"></i> Save Service</button>
        </form>
    </div>

    <div class="table-wrapper">
        <div class="table-top">
            <input type="text" id="searchBox" class="input-box small" placeholder="Search services...">
            <select id="entries" class="input-box small">
                <option>5</option>
                <option selected>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>

        <table class="services-table" id="serviceTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $i => $service)
                <tr>
                    <td> {{ $i+1 }} </td>
                    <td>
                        <img src="{{ asset('img/'.$service->image) }}" class="tbl-img">
                    </td>
                    <td> {{ $service->title }} </td>
                    <td> <i class="fa {{ $service->icon }} tbl-icon"></i> </td>
                    <td> {{ $service->description }} </td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.services.edit',$service->id) }}" class="tbl-edit">Edit</a>
                        <form action="{{ route('admin.services.delete',$service->id) }}" method="POST" onsubmit="return confirm('Delete this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tbl-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data">No services found.</td>
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
let table = document.querySelector("#serviceTable tbody");
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
