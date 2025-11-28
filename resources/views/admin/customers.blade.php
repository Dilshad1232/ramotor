@extends('admin.main')

@section('title', 'Customer List')

@section('content')
<div class="container-fluid py-3">

    <div class="card shadow-sm border-0 p-3 mb-4" style="background:#1c1c1c; border-radius:12px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h3 class="fw-bold m-0" style="color:#ff4d4d;">Customers List</h3>

            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn text-white fw-semibold px-3" style="background:#ff4d4d;">
                    <i class="fa fa-plus me-1"></i> New User
                </a>
            </div>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" class="d-flex flex-wrap gap-2 mb-3 align-items-center">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search name, email or phone..."
                class="form-control w-auto" style="min-width:200px;">

            <select name="limit" onchange="this.form.submit()" class="form-select w-auto">
                <option value="5"  {{ $limit == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                <option value="25" {{ $limit == 25 ? 'selected' : '' }}>25</option>
            </select>

            <button type="submit" class="btn text-white px-3" style="background:#ff4d4d;">Search</button>

            @if(session('success'))
            <div class="alert alert-success w-100 mt-2">{{ session('success') }}</div>
            @endif
        </form>

        {{-- TABLE --}}
        <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered table-hover text-white align-middle" style="background:#2c2c2c;">
                <thead style="background:#ff4d4d; color:white;">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr style="border-bottom:1px solid #333;">
                        <td>{{ $users->firstItem() + $index }}</td>

                        <td>
                            <img src="{{ asset('uploads/profile/' . $user->profile_image) }}" width="45" height="45"
                                 style="border-radius:50%; object-fit:cover; border:2px solid #ff4d4d;">
                        </td>

                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->city }}</td>

                        <td>
                            @if($user->status == 1)
                                <span style="color:green; font-weight:bold;">Active</span>
                            @else
                                <span style="color:red; font-weight:bold;">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.customer.details', $user->id) }}" class="btn btn-sm btn-success mb-1">
                                View
                            </a>
                            <form action="{{ route('admin.customer.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this customer?')"
                                    class="btn btn-sm btn-danger mb-1">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- CSS tweaks --}}
<style>
.table th, .table td { white-space: nowrap; vertical-align: middle; }
.table-hover tbody tr:hover { background:#333 !important; }
.pagination .page-link { background:#ff4d4d; color:white; border:none; margin:0 3px; border-radius:6px; }
.pagination .active .page-link { background:#222; color:white; }
</style>

@endsection
