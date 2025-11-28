@extends('admin.main')

@section('title', 'Mechanic Specializations')

@section('content')

<h2 class="page-title">🛠️ Mechanic Specializations</h2>

<div class="glass-card">
    <div class="table-responsive">
        <table class="mechanics-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Specialization</th>
                    <th>Profile Image</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mechanics as $i => $mechanic)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $mechanic->name }}</td>
                    <td>{{ $mechanic->phone }}</td>
                    <td>{{ $mechanic->specialization }}</td>
                    <td>
                        @if($mechanic->profile_image)
                            <img src="{{ asset($mechanic->profile_image) }}" alt="Profile" class="profile-img">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="no-data">No mechanics found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* Table Styling */
.table-responsive { overflow-x:auto; }

.mechanics-table {
    width: 100%;
    border-collapse: collapse;
    color: white;
    min-width: 600px;
}

.mechanics-table th, .mechanics-table td {
    padding: 12px 10px;
    text-align: left;
    font-size: 0.95rem;
}

.mechanics-table thead { background: #ff4d4d; color: white; }

.mechanics-table tbody tr { border-bottom: 1px solid #444; transition: background 0.3s; }

.mechanics-table tbody tr:hover { background: rgba(255,77,77,0.1); }

.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s;
}

.profile-img:hover { transform: scale(1.1); }

.no-data { text-align:center; padding:20px 0; color:#aaa; }

/* Mobile Responsive */
@media(max-width:768px){
    .mechanics-table, .mechanics-table thead, .mechanics-table tbody, .mechanics-table th, .mechanics-table td, .mechanics-table tr { display:block; }
    .mechanics-table thead { display:none; }
    .mechanics-table tbody tr { margin-bottom:15px; background:#111; border-radius:10px; padding:10px; }
    .mechanics-table td { padding:8px; text-align:right; position: relative; }
    .mechanics-table td::before { content: attr(data-label); position:absolute; left:10px; width:50%; font-weight:600; text-align:left; color:#ff4d4d; }
}
</style>

@endsection
