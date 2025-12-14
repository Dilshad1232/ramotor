@extends('admin.main')

@section('title', 'Contact Messages')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 page-title">📩 Contact Messages</h1>

    <!-- Search + Date Filter -->
    <form method="GET" action="{{ route('admin.contactview') }}" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name, email, phone, subject">
        </div>
        <div class="col-md-2">
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.contactview') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    <div class="card contact-card mb-4">
        <div class="card-header">
            <i class="fas fa-envelope"></i> All Contact Messages
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $key => $contact)
                        <tr>
                            <td>{{ ($contacts->currentPage()-1)*$contacts->perPage() + $key + 1 }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" class="text-primary" style="text-decoration:underline;">
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td style="max-width:240px; white-space:normal;">{{ $contact->message }}</td>
                            <td>{{ $contact->created_at->format('d M, Y') }}</td>
                            <td>
                                <form id="deleteForm{{ $contact->id }}" method="POST" action="{{ route('admin.contact.delete', $contact->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $contact->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">No messages found</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $contacts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Attach event listener to all delete buttons dynamically
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This message will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result)=>{
                if(result.isConfirmed){
                    document.getElementById('deleteForm'+id).submit();
                }
            });
        });
    });
});
</script>
@endsection
