@extends('admin.main')

@section('title', 'Customer List')

@section('content')
<h2 style="color:#ff4d4d; margin-bottom:15px;">Latest Booked Services</h2>

{{-- Search & Limit --}}
<form method="GET" style="margin-bottom:10px; display:flex; gap:10px; flex-wrap:wrap;">
    <input type="text" name="search" placeholder="Search by name, email, service..." value="{{ request('search') }}" style="padding:5px; border-radius:5px; border:1px solid #ccc;">
    <select name="limit" style="padding:5px; border-radius:5px; border:1px solid #ccc;">
        <option value="5" {{ request('limit')==5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('limit')==10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('limit')==20 ? 'selected' : '' }}>20</option>
    </select>
    <button type="submit" style="background:#ff4d4d;color:white;padding:5px 10px;border:none;border-radius:5px;">Apply</button>
</form>

<div class="card" style="padding:15px; overflow-x:auto;background:#531616;">
    <table style="width:100%; border-collapse:collapse; color:rgb(255, 255, 255);">
        <thead style="background:#b51313;">
            <tr>
                <th style="padding:8px;">#</th>
                <th style="padding:8px;">Name</th>
                <th style="padding:8px;">Email</th>
                <th style="padding:8px;">Service</th>
                <th style="padding: 8px;">Special Request</th>
                <th style="padding:8px;">Select Date</th>
                <th style="padding:8px;">Phone</th>
                <th style="padding:8px;">Address</th>
                <th style="padding:8px;">Status</th>
                <th style="padding:8px;">Action</th>
            </tr>
        </thead>
        <tbody style="font-size: smaller;">
            @foreach($latestBookings as $i => $booking)
            <tr style="border-bottom:1px solid hsl(0, 54%, 95%);">
                <td style="padding:8px;">{{ $latestBookings->firstItem() + $i }}</td>
                <td style="padding:8px;">{{ Str::limit($booking->name, 15) }}</td>
                <td style="padding:8px;">{{ Str::limit($booking->email, 20) }}</td>
                <td style="padding:8px;">{{ Str::limit($booking->service, 20) }}</td>
                <td style="padding: 8px">{{ Str::limit($booking->special_request, 20) }}</td>
                <td style="padding:8px;">{{ \Carbon\Carbon::parse($booking->service_date)->format('d M Y') }}</td>
                <td style="padding:8px;">{{ Str::limit($booking->phone, 15) }}</td>
                <td style="padding:8px;">{{ Str::limit($booking->address, 20) }}</td>
                <td style="padding:8px;">
                    @if($booking->status == 'pending')
                        <span style="color:#ffcc00;font-weight:bold;">Pending</span>
                    @elseif($booking->status == 'approved')
                        <span style="color:#00ff66;font-weight:bold;">Approved</span>
                    @else
                        <span style="color:red;font-weight:bold;">Rejected</span>
                    @endif
                    <br>
                    <button onclick="showModal({{ $booking }})" style="margin-top:5px; background:#ff4d4d;color:white;padding:2px 5px;border:none;border-radius:5px; font-size:0.6rem;">Read More</button>
                </td>
                <td style="padding:8px; display:flex; gap:2px;">
                    <form action="{{ route('admin.booking.approve', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit"
                            @if($booking->status == 'approved') disabled style="opacity:0.5; cursor:not-allowed; background:#00ff66;"
                            @else style="background:#00ff66;color:black;padding:5px 10px;border:none;border-radius:5px;" @endif>
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.booking.reject', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit"
                            @if($booking->status == 'rejected') disabled style="opacity:0.5; cursor:not-allowed; background:red;"
                            @else style="background:red;color:white;padding:5px 10px;border:none;border-radius:5px;" @endif>
                            Reject
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div style="margin-top:10px;">
        {{ $latestBookings->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal -->
<div id="readMoreModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; color:black; padding:20px; border-radius:10px; max-width:600px; width:90%; position:relative; max-height:80vh; overflow-y:auto;">
        <span style="position:absolute; top:10px; right:15px; cursor:pointer; font-weight:bold; font-size:1.2rem;" onclick="closeModal()">×</span>
        <div id="modalContent"></div>
    </div>
</div>

<script>
function showModal(booking){
    let html = `<h3 style="margin-bottom:15px; color:#ff4d4d;">Booking Details</h3>
        <p><strong>Name:</strong> ${booking.name}</p>
        <p><strong>Email:</strong> ${booking.email}</p>
        <p><strong>Service:</strong> ${booking.service}</p>
        <p><strong>Special Request:</strong> ${booking.special_request}</p>
        <p><strong>Date:</strong> ${booking.service_date}</p>
        <p><strong>Phone:</strong> ${booking.phone}</p>
        <p><strong>Address:</strong> ${booking.address}</p>
        <p><strong>Status:</strong> ${booking.status}</p>
    `;
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('readMoreModal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('readMoreModal').style.display = 'none';
}
</script>

<style>
.ellipsis {
    max-width: 120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

@endsection


