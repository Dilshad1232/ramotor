@extends('user.main')
@section('title','Schedule Service')
@section('content')

<h2 class="page-title">📅 Schedule Services</h2>

{{-- Search & Filter --}}
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by service or status..." value="{{ request('search') }}">
        <select name="status">
            <option value="">All Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
            <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
        </select>
        <button type="submit">Apply</button>
    </form>
</div>

{{-- Upcoming Services --}}
<div class="services-container">
    @forelse($bookings as $booking)
    <div class="service-card">
        <div class="service-header">
            <h3>{{ $booking->service }}</h3>
            <span class="status {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
        </div>
        <div class="service-body">
            <p><strong>Scheduled Date:</strong> {{ \Carbon\Carbon::parse($booking->service_date)->format('d M Y') }}</p>
            <p><strong>Special Request:</strong> {{ Str::limit($booking->special_request, 50) ?? '-' }}</p>
        </div>
        <div class="service-actions">
            <button class="btn view-btn" onclick="showDetails({{ $booking }})">View Details</button>

            @if($booking->status != 'rejected')
            @if($booking->status != 'approved')
    <button class="btn reschedule-btn"
    onclick="openReschedule('{{ $booking->id }}', '{{ $booking->service_date }}')">
    Reschedule
    </button>
@endif

@if($booking->status != 'approved')
{{-- <button class="btn cancel-btn" onclick="cancelBooking({{ $booking->id }})">Rejected</button> --}}
@endif
<script>
function cancelBooking(id){
if(confirm('Are you sure you want to cancel this booking?')){
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = '/user/booking/cancel/' + id;

    let csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    document.body.appendChild(form);
    form.submit();
}
}
</script>

            @endif
        </div>
    </div>
    @empty
    <p class="no-services">No upcoming services scheduled.</p>
    @endforelse
</div>

{{-- Reschedule Modal --}}
<div id="rescheduleModal" style="display:none;">
    <div class="modal-overlay" onclick="closeReschedule()"></div>
    <div class="modal-content">
        <span class="close-btn" onclick="closeReschedule()">×</span>
        <h3>Reschedule Service</h3>
        <form id="rescheduleForm" method="POST">
            @csrf
            @method('PUT')
            <label>New Date:</label>
            <input type="date" name="new_date" id="rescheduleDate" required>
            <button type="submit" class="btn">Save</button>
        </form>
    </div>
</div>

{{-- Details Modal --}}
<div id="detailsModal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">×</span>
        <div id="modalDetails"></div>
    </div>
</div>

{{-- Scripts --}}
<script>
function openReschedule(id, date) {
    document.getElementById('rescheduleModal').style.display = 'flex';
    let correctDate = date.split(' ')[0];
    document.getElementById('rescheduleDate').value = correctDate;
    document.getElementById('rescheduleForm').action = "/user/reschedule/" + id;
}

function closeReschedule() {
    document.getElementById('rescheduleModal').style.display = 'none';
}

function showDetails(booking){
    let html = `
        <h2 style="color:#ff4d4d;margin-bottom:15px;">Booking Details</h2>
        <p><strong>Name:</strong> ${booking.name}</p>
        <p><strong>Email:</strong> ${booking.email}</p>
        <p><strong>Service:</strong> ${booking.service}</p>
        <p><strong>Scheduled Date:</strong> ${booking.service_date}</p>
        <p><strong>Special Request:</strong> ${booking.special_request || '-'}</p>
        <p><strong>Phone:</strong> ${booking.phone}</p>
        <p><strong>Address:</strong> ${booking.address}</p>
        <p><strong>Status:</strong> ${booking.status.charAt(0).toUpperCase()+booking.status.slice(1)}</p>
    `;
    document.getElementById('modalDetails').innerHTML = html;
    document.getElementById('detailsModal').style.display = 'flex';
}

function closeModal(){ document.getElementById('detailsModal').style.display = 'none'; }

// function cancelBooking(id){
//     if(confirm('Are you sure you want to cancel this booking?')){
//         let form = document.createElement('form');
//         form.method = 'POST';
//         form.action = '/user/booking/cancel/' + id;

//         let csrf = document.createElement('input');
//         csrf.type = 'hidden';
//         csrf.name = '_token';
//         csrf.value = '{{ csrf_token() }}';
//         form.appendChild(csrf);

//         document.body.appendChild(form);
//         form.submit();
//     }
// }
</script>

{{-- Pagination --}}
@if ($bookings->lastPage() > 1)
<div class="pagination-wrapper">
    @if($bookings->onFirstPage())
        <span class="page-btn disabled">‹ Previous</span>
    @else
        <a href="{{ $bookings->previousPageUrl() }}" class="page-btn">‹ Previous</a>
    @endif

    @for ($i = 1; $i <= $bookings->lastPage(); $i++)
        @if ($i == $bookings->currentPage())
            <span class="page-btn current">{{ $i }}</span>
        @else
            <a href="{{ $bookings->url($i) }}" class="page-btn">{{ $i }}</a>
        @endif
    @endfor

    @if($bookings->hasMorePages())
        <a href="{{ $bookings->nextPageUrl() }}" class="page-btn">Next ›</a>
    @else
        <span class="page-btn disabled">Next ›</span>
    @endif
</div>
@endif

{{-- Styles (unchanged, clean) --}}
<style>
.page-title{color:#ff4d4d;font-size:1.8rem;text-align:center;margin-bottom:25px;font-weight:700;}
.filter-bar{display:flex;justify-content:center;margin-bottom:20px;}
.filter-form{display:flex;gap:10px;flex-wrap:wrap;}
.filter-form input,.filter-form select{padding:10px 15px;border-radius:8px;border:1px solid #ccc;outline:none;font-size:0.95rem;}
.filter-form button{background:#ff4d4d;color:white;padding:10px 20px;border:none;border-radius:8px;cursor:pointer;transition:0.3s;}
.filter-form button:hover{background:#e03a3a;}
.services-container{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;}
.service-card{background:#1c1c1c;color:#fff;border-radius:12px;padding:20px;box-shadow:0 6px 18px rgba(0,0,0,0.5);transition:0.3s;display:flex;flex-direction:column;justify-content:space-between;}
.service-card:hover{transform:translateY(-3px);box-shadow:0 10px 25px rgba(0,0,0,0.6);}
.service-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;}
.service-header h3{margin:0;color:#ff4d4d;}
.status{padding:3px 10px;border-radius:12px;font-size:0.85rem;font-weight:600;text-transform:capitalize;}
.status.pending{background:#ffcc00;color:#111;}
.status.approved{background:#00ff66;color:#111;}
.status.rejected{background:red;color:white;}
.service-body p{margin:5px 0;font-size:0.9rem;}
.service-actions{display:flex;gap:10px;margin-top:15px;}
.btn{padding:8px 12px;border:none;border-radius:8px;cursor:pointer;transition:0.3s;}
.view-btn{background:#ff4d4d;color:white;}
.view-btn:hover{background:#e03a3a;}
.reschedule-btn{background:#1c8cff;color:white;}
.reschedule-btn:hover{background:#007acc;}
.cancel-btn{background:red;color:white;}
.cancel-btn:hover{background:#cc0000;}
.no-services{text-align:center;font-size:1rem;color:#ccc;grid-column:1/-1;}
.pagination-wrapper{margin-top:20px;display:flex;justify-content:center;flex-wrap:wrap;gap:5px;}
.page-btn{padding:6px 12px;background:#eee;border-radius:6px;color:#333;text-decoration:none;}
.page-btn.current{background:#ff4d4d;color:white;}
.page-btn.disabled{background:#ddd;color:#666;}
#detailsModal,#rescheduleModal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;justify-content:center;align-items:center;z-index:9999;}
.modal-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);}
.modal-content{background:#1c1c1c;color:white;padding:25px;border-radius:12px;max-width:500px;width:90%;position:relative;max-height:80vh;overflow-y:auto;box-shadow:0 10px 30px rgba(0,0,0,0.7);}
.close-btn{position:absolute;top:10px;right:15px;cursor:pointer;font-weight:bold;font-size:1.5rem;}
.modal-content h3{color:#ff4d4d;margin-bottom:15px;}
.modal-content form{display:flex;flex-direction:column;gap:15px;}
.modal-content form input{padding:10px;border-radius:8px;border:1px solid #ccc;}
.modal-content form button{background:#ff4d4d;color:white;padding:10px;border-radius:8px;border:none;cursor:pointer;transition:0.3s;}
.modal-content form button:hover{background:#e03a3a;}
@media(max-width:767px){.filter-form{flex-direction:column;gap:10px;}.service-card{padding:15px;}.service-actions{flex-direction:column;gap:10px;}}
</style>

@endsection
