@extends('user.main')
@section('title','My Services')
@section('content')

<h2 class="page-title">🛠️ My Services</h2>

{{-- Search & Filter --}}
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by service or status..." value="{{ request('search') }}">
        <select name="limit">
            <option value="5" {{ request('limit')==5?'selected':'' }}>5 per page</option>
            <option value="10" {{ request('limit')==10?'selected':'' }}>10 per page</option>
            <option value="20" {{ request('limit')==20?'selected':'' }}>20 per page</option>
        </select>
        <button type="submit">Apply</button>
    </form>
</div>

{{-- Services --}}
<div class="services-container">
    @forelse($bookings as $booking)
    <div class="service-card">
        <div class="service-header">
            <h3>{{ $booking->service }}</h3>
            <span class="status {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
        </div>
        <div class="service-body">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->service_date)->format('d M Y') }}</p>
            <p><strong>Special Request:</strong> {{ Str::limit($booking->special_request, 50) ?? '-' }}</p>
        </div>
        <div class="service-actions d-flex justify-content-between">
            <button class="view-btn" onclick="showModal({{ $booking }})">View Details</button>

            <!-- ✅ Download Receipt Button -->
            <a href="{{ route('booking.receipt', $booking->id) }}" class="btn btn-success download-btn">
                Download Receipt
            </a>
        </div>
    </div>
    @empty
        <p class="no-services">No services booked yet.</p>
    @endforelse
</div>

{{-- Pagination --}}
@if ($bookings->lastPage() > 1)
<div style="display:flex; justify-content:center; align-items:center; gap:5px; margin-top:20px; flex-wrap:wrap;">
    {{-- Previous --}}
    @if($bookings->onFirstPage())
        <span style="padding:6px 12px; background:#ddd; border-radius:6px; color:#666;">‹ Previous</span>
    @else
        <a href="{{ $bookings->previousPageUrl() }}" style="padding:6px 12px; background:#ff4d4d; border-radius:6px; color:white; text-decoration:none;">‹ Previous</a>
    @endif

    {{-- Page numbers --}}
    @for ($i = 1; $i <= $bookings->lastPage(); $i++)
        @if ($i == $bookings->currentPage())
            <span style="padding:6px 12px; background:#ff4d4d; border-radius:6px; color:white;">{{ $i }}</span>
        @else
            <a href="{{ $bookings->url($i) }}" style="padding:6px 12px; background:#eee; border-radius:6px; color:#333; text-decoration:none;">{{ $i }}</a>
        @endif
    @endfor

    {{-- Next --}}
    @if($bookings->hasMorePages())
        <a href="{{ $bookings->nextPageUrl() }}" style="padding:6px 12px; background:#ff4d4d; border-radius:6px; color:white; text-decoration:none;">Next ›</a>
    @else
        <span style="padding:6px 12px; background:#ddd; border-radius:6px; color:#666;">Next ›</span>
    @endif
</div>
@endif


{{-- Premium Modal --}}
<div id="serviceModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.75); justify-content:center; align-items:center; z-index:9999; padding:15px;">
    <div style="background:#222; color:white; padding:30px; border-radius:16px; max-width:600px; width:100%;
        position:relative; max-height:85vh; overflow-y:auto; box-shadow:0 15px 40px rgba(0,0,0,0.8);
        border:1px solid #ff4d4d; transition:0.3s;">

        <span style="position:absolute; top:15px; right:20px; cursor:pointer; font-weight:bold; font-size:1.5rem;
            background:#ff4d4d; color:white; padding:2px 8px; border-radius:50%;" onclick="closeModal()">×</span>

        <div id="modalContent" style="line-height:1.6; font-size:0.95rem;"></div>
    </div>
</div>

<script>
function showModal(booking){
    let html = `
        <h2 style="color:#ff4d4d; margin-bottom:15px; text-align:center;">🛠 Booking Details</h2>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <div><strong>Name:</strong> ${booking.name}</div>
            <div><strong>Email:</strong> ${booking.email}</div>
            <div><strong>Service:</strong> ${booking.service}</div>
            <div><strong>Date:</strong> ${new Date(booking.service_date).toLocaleDateString('en-US', {day:'2-digit', month:'short', year:'numeric'})}</div>
            <div><strong>Special Request:</strong> ${booking.special_request || '-'}</div>
            <div><strong>Phone:</strong> ${booking.phone}</div>
            <div><strong>Address:</strong> ${booking.address}</div>
            <div><strong>Status:</strong>
                <span style="
                    padding:3px 10px; border-radius:12px; font-weight:600;
                    background:${booking.status=='pending'?'#ffcc00':booking.status=='approved'?'#00ff66':'red'};
                    color:${booking.status=='pending'?'#111':booking.status=='approved'?'#111':'#fff'};">
                    ${booking.status.charAt(0).toUpperCase()+booking.status.slice(1)}
                </span>
            </div>
        </div>
    `;
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('serviceModal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('serviceModal').style.display = 'none';
}
</script>

<style>
.page-title {
    color:#ff4d4d;
    font-size:1.8rem;
    text-align:center;
    margin-bottom:25px;
    font-weight:700;
}


.view-btn { background: #0D6EFD; color: #fff; border: none; }
.download-btn { background: #28A745; color: #fff; }


/* Filter bar */
.filter-bar {
    display:flex;
    justify-content:center;
    margin-bottom:20px;
}
.filter-form {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}
.filter-form input, .filter-form select {
    padding:10px 15px;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    font-size:0.95rem;
}
.filter-form button {
    background:#ff4d4d;
    color:white;
    padding:10px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}
.filter-form button:hover { background:#e03a3a; }

/* Services Grid */
.services-container {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap:20px;
}

/* Service Card */
.service-card {
    background:#1c1c1c;
    color:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.5);
    transition:0.3s;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}
.service-card:hover {
    transform: translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.6);
}
.service-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}
.service-header h3 {
    margin:0;
    color:#ff4d4d;
}
.status {
    padding:3px 10px;
    border-radius:12px;
    font-size:0.85rem;
    font-weight:600;
    text-transform:capitalize;
}
.status.pending { background:#ffcc00; color:#111; }
.status.approved { background:#00ff66; color:#111; }
.status.rejected { background:red; color:white; }

.service-body p {
    margin:5px 0;
    font-size:0.9rem;
}
.view-btn {
    margin-top:15px;
    padding:8px 12px;
    background:#ff4d4d;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}
.view-btn:hover { background:#e03a3a; }

/* No services message */
.no-services {
    text-align:center;
    font-size:1rem;
    color:#ccc;
    grid-column:1/-1;
}

/* Pagination wrapper */
.pagination-wrapper {
    margin-top:20px;
    display:flex;
    justify-content:center;
}

/* Mobile responsive */
@media(max-width:767px) {
    .filter-form { flex-direction:column; gap:10px; }
    .service-card { padding:15px; }
}
</style>

@endsection
