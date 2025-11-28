@extends('admin.main')
@section('title','Services')

@section('content')
<div class="container-fluid py-3">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0" style="color:#ff3232;">Services</h3>
        <a href="#" class="btn text-white fw-semibold px-3" style="background:#ff3232;">
            <i class="fa fa-plus"></i> Add Service
        </a>
    </div>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔥 Add Service Form --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 p-3">
            <h5 class="fw-bold m-0" style="color:#ff3232;">
                <i class="fa fa-gears me-1"></i> Add New Service
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Title *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa fa-heading text-secondary"></i></span>
                            <input type="text" name="title" class="form-control" placeholder="Service Title *" required>
                        </div>
                    </div>

                    <!-- Icon -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Icon Class *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa fa-icons text-secondary"></i></span>
                            <input type="text" name="icon" class="form-control" id="iconInput"
                                   placeholder="e.g. fa-car-side, fa-tools"
                                   onkeyup="previewIcon.className='fa '+this.value" required>
                            <span class="input-group-text bg-white">
                                <i id="previewIcon" class="fa fa-car-side text-danger"></i>
                            </span>
                        </div>
                        <small class="text-muted">Enter full FontAwesome class (FA 6 Supported)</small>
                    </div>

                    <!-- Image -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Image *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa fa-image text-secondary"></i></span>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description *</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Short Description..." required></textarea>
                    </div>

                </div>

                <button class="btn mt-3 text-white fw-bold px-4" type="submit" style="background:#ff3232;">
                    <i class="fa fa-check-circle me-1"></i> Save Service
                </button>
            </form>

        </div>
    </div>

    {{-- 🔥 Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                <input type="text" id="searchBox" class="form-control w-auto" placeholder="Search services...">
                <select id="entries" class="form-select w-auto">
                    <option>5</option>
                    <option selected>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="serviceTable">
                    <thead style="background:#ff3232; color:#fff;">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Description</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $i => $service)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
                                <img src="{{ asset('img/'.$service->image) }}" width="60" height="50" style="border-radius:6px;">
                            </td>
                            <td class="fw-semibold">{{ $service->title }}</td>
                            <td>
                                <i class="fa {{ $service->icon }}" style="font-size:22px; color:#ff3232;"></i>
                            </td>
                            <td>{{ $service->description }}</td>
                            <td>
                                <a href="{{ route('admin.services.edit',$service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.services.delete',$service->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this service?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
                <div id="recordInfo" class="fw-bold small"></div>
                <div class="d-flex gap-1" id="paginationBtns"></div>
            </div>

        </div>
    </div>
</div>

{{-- Pagination CSS --}}
<style>
#paginationBtns button {
    border:1px solid #ff3232;
    background:white;
    color:#ff3232;
    font-size:13px;
    padding:5px 12px;
    border-radius:6px;
    font-weight:600;
}
#paginationBtns button.active,
#paginationBtns button:hover {
    background:#ff3232;
    color:#fff;
}
.table td, .table th { vertical-align: middle; }
</style>

{{-- Search + Pagination --}}
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
